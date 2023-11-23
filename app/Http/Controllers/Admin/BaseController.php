<?php 
namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use Image, File AS FileInput, DB, Auth;
use Spiderworks\Webadmin\Models\Media;
use Illuminate\Support\Str;

class BaseController extends Controller {

    protected $route, $views;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->route = $this->views = 'admin';
    }

    protected function uploadFile($fileInput = 'image', $filePath = 'uploads/', $file_update_name=null, $varient=array()) {
        
        $destinationPath = public_path($filePath);
        $returnFilename = null;
        $result = array('success' => false, 'error' => '', 'filepath' => '');
        $file = is_object($fileInput) ? $fileInput : Input::file($fileInput);

            
        
        if ( (is_object($fileInput) || Input::hasFile($fileInput)) && $file->isValid()) {
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileType = $file->getMimeType();

            $fileDimensions = null;
            if(substr($file->getMimeType(), 0, 5) == 'image') {
                $type = "Image";
                $imagedetails = getimagesize($file);
                $width = (!empty($imagedetails[0]))?$imagedetails[0]:0;
                $height = (!empty($imagedetails[1]))?$imagedetails[1]:0;
                if($width && $height)
                    $fileDimensions = $width." X ".$height;
                $thumb_image = NULL;
            }
            else if(substr($file->getMimeType(), 0, 5) == 'video') {
                $type = "Video";
                $thumb_image = 'admin/assets/images/docs/video.jpg';
            }
            else if(substr($file->getMimeType(), 0, 5) == 'audio') {
                $type = "Audio";
                $thumb_image = 'admin/assets/images/docs/audio.png';
            }
            else if($file->getMimeType() == 'application/msword') {
                $type = "DOC";
                $thumb_image = 'admin/assets/images/docs/doc.png';
            }
            else if($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                $type = "DOCX";
                $thumb_image = 'admin/assets/images/docs/docx.png';
            }
            else if($file->getMimeType() == 'application/vnd.ms-excel') {
                $type = "XLS";
                $thumb_image = 'admin/assets/images/docs/xls.png';
            }
            else if($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                $type = "XLSX";
                $thumb_image = 'admin/assets/images/docs/xlsx.png';
            }
            else if($file->getMimeType() == 'application/vnd.ms-powerpoint') {
                $type = "PPT";
                $thumb_image = 'admin/assets/images/docs/ppt.png';
            }
            else if($file->getMimeType() == 'application/vnd.openxmlformats-officedocument.presentationml.presentation') {
                $type = "PPTX";
                $thumb_image = 'admin/assets/images/docs/pptx.png';
            }
            else if($file->getMimeType() == 'application/pdf') {
                $type = "PDF";
                $thumb_image = 'admin/assets/images/docs/pdf.jpg';
            }
            else {
                $type = "File";
                $thumb_image = 'admin/assets/images/docs/file.png';
            }

            
            $file_parts = pathinfo($fileName);
            $file_ext = $file_parts['extension'];
            $file_name = Str::slug($file_parts['filename']);
            if(!$file_update_name)
            {
                $i = 0;
                $extra = uniqid();
                while (file_exists($destinationPath . $file_name . $extra . '.' . $file_ext)) {
                    $i++;
                    $extra = '_' . $i;
                }
                $fileName = $file_name . $extra . '.' . $file_ext;
            }
            else{
                $file_update_parts = pathinfo($file_update_name);
                $fileName = $file_update_parts['filename'].'.'.$file_ext;
            }

            if(!FileInput::isDirectory($destinationPath)) {
                // path does not exist
                FileInput::makeDirectory($destinationPath, 0755, true);
            }
            $success = false;
            $this->delete_if_exist($filePath, $fileName);
            if($file->move($destinationPath, $fileName))
                $success = true;
            
            if($success)
            {
                $result['filename'] = $fileName;
                $result['filepath'] = $filePath . $fileName;
                $result['filesize'] = $fileSize;
                $result['filedimensions'] = $fileDimensions;
                $result['mediatype'] = $type;
                $result['mediathumb'] = $thumb_image;
                $result['filetype'] = $fileType;
                $result['success'] = true;
            }
            else
                $result['error'] = 'Something wrong happend, please try again.';
        } else {
            $result['error'] = 'No file selected or Invalid file.';         
        }
        return $result;
    }

    protected function uploadCover($file){
        $destinationPath = public_path('uploads/media/cover');
        $fileName = $file->getClientOriginalName();

        $file_parts = pathinfo($fileName);
        $file_ext = $file_parts['extension'];
        $file_name = Str::slug($file_parts['filename']);
        $i = 0;
        $extra = uniqid();
        while (file_exists($destinationPath . $file_name . $extra . '.' . $file_ext)) {
            $i++;
            $extra = '_' . $i;
        }
        $fileName = $file_name . $extra . '.' . $file_ext;

        if(!FileInput::isDirectory($destinationPath)) {
            // path does not exist
            FileInput::makeDirectory($destinationPath, 0755, true);
        }
        $success = false;
        $this->delete_if_exist('uploads/media/cover', $fileName);
        if($file->move($destinationPath, $fileName))
            $success = true;

        $result = array('success' => false, 'error' => '', 'filename' => '');
        if($success)
        {
            $result['filename'] = $fileName;
            $result['success'] = true;
        }
        else
            $result['error'] = 'Something wrong happend, please try again.';
        return $result;
    }

    public function delete_if_exist($destination, $file_name)
    {
        $path = $destination.'/'.$file_name;
        if(file_exists(public_path($path))){
            @unlink(public_path($path));
        }
        return true;
    }

    public function create_image($width, $height, $destination, $filename, $file)
    {
        // create new image with transparent background color
        $background = Image::canvas($width, $height);

        // read image file and resize it to 200x200
        // but keep aspect-ratio and do not size up,
        // so smaller sizes don't stretch
        $image = Image::make($file)->resize($width, $height, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });

        // insert resized image centered into background
        $background->insert($image, 'center');

        // save or do whatever you like
        $background->save($destination.'/'.$filename, 100);
        return true;
    }

    public static function slug($slug){
        return strtolower(preg_replace( '/[-+()^ $%&.*~]+/', '-', $slug));
    }

    public function saveMedia($upload)
    {
        $media = new Media;
        $media->file_name = $upload['filename'];
        $media->file_path = $upload['filepath'];
        $media->thumb_file_path = $upload['mediathumb'];
        $media->file_type = $upload['filetype'];
        $media->file_size = $upload['filesize'];
        $media->dimensions = $upload['filedimensions'];
        $media->media_type = $upload['mediatype'];
        if(isset($upload['related_type']) && $upload['related_type']!='' && isset($upload['related_id']) && $upload['related_id']!='')
        {
            $media->related_type = $upload['related_type'];
            $media->related_id = $upload['related_id'];
        }
        $media->created_by = $media->updated_by = Auth::user()->id;
        $media->save();
                
        $data = array(
                    'name' => $media->file_name,
                    'size' => $media->file_size,
                    'id' => $media->id,
                    'original_file' => \URL::to('').'/public/'.$media->file_path,
                    'type' => $media->file_type,
                    'url' => $media->thumb_file_path,
                );
        return $data;
    }

}