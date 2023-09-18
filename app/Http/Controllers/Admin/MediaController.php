<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use Illuminate\Http\Request as HttpRequest;
use App\Models\Media;
use View, Auth;

class MediaController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Media;
        $this->route = 'admin.media';
        $this->views = 'admin.media';

        $this->permissions = ['list'=>'media_listing', 'create'=>'media_adding', 'edit'=>'media_editing', 'delete'=>'media_deleting'];

        $this->resourceConstruct();

    }

    protected function getCollection() {}

    protected function setDTData($collection) {}

    protected function getSearchSettings(){}

    public function show($id)
    {
        $id = decrypt($id);
		if($file = Media::find($id))
		{
			return view($this->views.'.view', array('file'=>$file));
		}
    }

    public function index(HttpRequest $request)
	{
		$req = isset($_GET['req'])?$_GET['req']:null;
		$page = isset($_GET['page'])?$_GET['page']:1;
		$sort = !empty($_GET['sort'])?$_GET['sort']:null;
		if(request()->has('req'))
		{
			$req = request()->get('req');
			$result = Media::where('file_name', 'like', '%' . request()->get('req') . '%');
		}
		if(request()->has('sort'))
		{
			$sort = request()->get('sort');
			switch ($sort) {
				case 'SHL':
					if(!$req)
						$result = Media::orderBy('file_size', 'DESC');
					else
						$result->orderBy('file_size', 'DESC');
					break;
				
				case 'SLH':
					if(!$req)
						$result = Media::orderBy('file_size', 'ASC');
					else
						$result->orderBy('file_size', 'ASC');
					break;
			}
		}
		if(!$req && !$sort){
			$result = Media::orderBy('created_at', 'desc');
		}
		else
			$result->orderBy('created_at', 'desc');
		$files = $result->Paginate(12);
		if ($request->ajax()) {
			if(request()->has('action'))
			{
				$file_view = View::make($this->views.'.ajax_index', array('files'=>$files, 'req'=>$req, 'page'=>$page, 'sort'=>$sort));
	            return $file_view->render();
			}
			else
				return view($this->views.'.ajax_index', array('files'=>$files, 'req'=>$req, 'page'=>$page, 'sort'=>$sort));
		}
		else{
			return view($this->views.'.index', array('files'=>$files, 'req'=>$req, 'page'=>$page, 'sort'=>$sort));
		}
	}

	public function destroy()
	{
		if(request()->has('action'))
		{
			if(request()->get('action') == 'delete'){
				$id = request()->get('id');
				$file = Media::find($id);
				if($file)
				{
					if(file_exists(public_path($file->file_path))){
	                    @unlink(public_path($file->file_path));
	                }
	                if($file->media_type == 'Image'){
		                if($file->thumb_file_path && file_exists(public_path($file->thumb_file_path))){
		                    @unlink(public_path($file->thumb_file_path));
		                }
		                if($file->slider_file_path && file_exists(public_path($file->slider_file_path))){
		                    @unlink(public_path($file->slider_file_path));
		                }
		            }
		            $file->forcedelete();
		        }
			}
			if(request()->get('action') == 'bulk_delete')
			{
				$ids = request()->get('ids');
				foreach ($ids as $key => $id) {
					$file = Media::find($id);
					if($file)
					{
						if(file_exists(public_path($file->file_path))){
		                    @unlink(public_path($file->file_path));
		                }
		                if($file->media_type == 'Image'){
			                if($file->thumb_file_path && file_exists(public_path($file->thumb_file_path))){
			                    @unlink(public_path($file->thumb_file_path));
			                }
			                if($file->slider_file_path && file_exists(public_path($file->slider_file_path))){
			                    @unlink(public_path($file->slider_file_path));
			                }
			            }
			            $file->forcedelete();
					}
				}
			}
		}

		$data = $this->index(request());
		return response()->json($data);

	}

	public function ajaxIndex()
	{
		return view($this->views.'.ajax_index');
	}

	public function popup(httpRequest $request, $popup_type="photos", $type=null, $holder_attr="", $title='Media', $related_id=null, $media_id=null, $display='vertical')
	{
		if($type && $type != 'all')
		{
			$typeArr =  explode('-', $type);
			$result = Media::whereIn('media_type', $typeArr)->orderBy('created_at', 'DESC');
		}
		else
			$result = Media::orderBy('created_at', 'DESC');

		$req = isset($_GET['req'])?$_GET['req']:null;
		$page = isset($_GET['page'])?$_GET['page']:1;
		if($request->has('req'))
		{
			$req = $request->get('req');
			$type = $request->get('type');
			if($type && $type != 'all')
			{
				$typeArr =  explode('-', $type);
				$result = $result->whereIn('media_type', $typeArr);
			}
			$result->where('file_name', 'like', '%' . $request->get('req') . '%');
		}

		$files = $result->Paginate(12);
		
		$popTypeArr = explode('-', $popup_type);
		$popup_type = $popTypeArr[0];
		$id = isset($popTypeArr[1])?$popTypeArr[1]:null;

		if (isset($_GET['req']) || isset($_GET['page'])) {
			return view($this->views.'.ajax_index_popup', array('files'=>$files, 'req'=>$req, 'page'=>$page, 'popup_type'=>$popup_type, 'id'=>$id, 'holder_attr'=>$holder_attr, 'related_id'=>$related_id, 'type'=>$type, 'title'=>$title, 'media_id'=>$media_id, 'display'=>$display));
		}
		else{
			return view($this->views.'.popup', array('files'=>$files, 'req'=>$req, 'page'=>$page, 'popup_type'=>$popup_type, 'id'=>$id, 'holder_attr'=>$holder_attr, 'related_id'=>$related_id, 'type'=>$type, 'title'=>$title, 'media_id'=>$media_id, 'display'=>$display));
		}
	}

	public function save(HttpRequest $request)
	{
		$files = request()->file('files');
		$json = array(
        	'files' => array()
        );
	    foreach ($files as $key=> $file) {
		    $upload = $this->uploadFile($file, $this->model->uploadPath['media']);
		    if($upload['success']) {

		    	$media = $this->model;
		    	$media->file_name = $upload['filename'];
		    	$media->file_path = $upload['filepath'];
		    	$media->thumb_file_path = $upload['mediathumb'];
		    	$media->file_type = $upload['filetype'];
		    	$media->file_size = $upload['filesize'];
		    	$media->dimensions = $upload['filedimensions'];
		    	$media->media_type = $upload['mediatype'];
		    	$media->created_by = Auth::user()->id;
		    	$media->updated_by = Auth::user()->id;
		    	$media->save();
		    	
		    	if(request()->popupType == 'main')
		    	{
		    		$file_view = View::make($this->views.'.item', [ 'file' => $media]);
            		$file_html = $file_view->render();
            		$json['files'][] = $file_html;
            	}
            	else
            	{
            		$file_view = View::make($this->views.'.file_single', [ 'file' => $media, 'is_new'=>1]);
            		$file_html = $file_view->render();

            		$file_details_view = View::make($this->views.'.image_details', [ 'file' => $media]);
            		$file_details_html = $file_details_view->render();
            		$json['files'][] = ['file_html'=>$file_html, 'file_details_html'=>$file_details_html];
            	}

			    
			}
	    }
	    return response()->json($json);
	}

	public function update(HttpRequest $request)
	{
		$id = decrypt($request->id);
		if($media = Media::find($id))
		{
			$json = ['success'=>false, 'id'=> $id, 'list_html'=>'', 'view_html'=>''];
			$files = $request->file('files');
			if($request->type == "Cover"){
				if(isset($files[0]) && $files[0]->isValid()){
					$upload = $this->uploadCover($files[0]);
					if($upload['success']) {
						$media->thumb_file_path = 'uploads/media/cover/'.$upload['filename'];
						$media->save();
					}
				}
				
			}
			else{
				foreach ($files as $key=> $file) {
					$upload = $this->uploadFile($file, $this->model->uploadPath['media'], $media->file_name);
					if($upload['success']) {

						$media->file_name = $upload['filename'];
						$media->file_path = $upload['filepath'];
						$media->thumb_file_path = $upload['mediathumb'];
						$media->file_type = $upload['filetype'];
						$media->file_size = $upload['filesize'];
						$media->dimensions = $upload['filedimensions'];
						$media->media_type = $upload['mediatype'];
						$media->updated_by = Auth::user()->id;
						$media->save();
					}
				}
			}
			$file_view = View::make($this->views.'.item', [ 'file' => $media]);
			$file_html = $file_view->render();

			$file_view2 = View::make($this->views.'.edit', [ 'file' => $media]);
			$file_html2 = $file_view2->render();

			$json['success'] = true;
			$json['list_html'] = $file_html;
			$json['view_html'] = $file_html2;
			return response()->json($json);
		}
		return response()->json(array('success'=>false, 'error'=>'Media not found!'));
	}

	public function storeExtra($id)
	{
		if($media = Media::find($id))
		{
			$json = ['success'=>false, 'id'=> $id, 'list_html'=>'', 'view_html'=>''];
			if(trim(request()->get('file_name')) != '')
			{
				$file_parts = pathinfo($media->file_name);
				$file_ext = $file_parts['extension'];
                $file_name = $file_parts['filename'];

                $new_file_name = request()->get('file_name');
                $folder = str_replace($media->file_name, '', $media->file_path);
                $i = 0;
                $extra = uniqid();
                while (file_exists(public_path($folder) . $new_file_name . $extra . '.' . $file_ext)) {
                    $i++;
                    $extra = '_' . $i;
                }
                $new_file = $new_file_name . $extra . '.' . $file_ext;

                if($media->file_name != $new_file_name. '.' . $file_ext)
                {
                	
                	$thumb_folder = str_replace($media->file_name, '', $media->thumb_file_path);
                	rename(public_path($media->file_path), public_path($folder.$new_file));
                	$media->file_name = $new_file;
                	$media->file_path = $folder.$new_file;
                	if($media->media_type == "Image")
                	{
                		rename(public_path($media->thumb_file_path), public_path($thumb_folder.$new_file));
                		$media->thumb_file_path = $thumb_folder.$new_file;
                	}
                }
			}
			$media->title = request()->get('title');
			$media->description = request()->get('description');
			$media->alt_text = request()->get('alt_text');
			$media->save();

			if(request()->show_type == 'popup')
			{
				return view($this->views.'.image_details', array('file'=>$media));
			}
			else{
				$file_view = View::make($this->views.'.item', [ 'file' => $media]);
		        $file_html = $file_view->render();

		        $file_view2 = View::make($this->views.'.edit', [ 'file' => $media]);
		        $file_html2 = $file_view2->render();

		        $json['success'] = true;
				$json['list_html'] = $file_html;
				$json['view_html'] = $file_html2;
				return response()->json($json);
			}
		}
		return response()->json(array('success'=>false, 'error'=>'Media not found!'));
	}

	public function edit($id, $type=null)
	{
		$id = decrypt($id);
		if($file = Media::find($id))
		{
			if($type)
				return view($this->views.'.image_details', array('file'=>$file, 'show_type'=>'popup'));
			else
				return view($this->views.'.edit', array('file'=>$file));
		}
	}

	public function set_media()
	{
		$id = request()->id;
		$id = decrypt($id);

		if($file = Media::find($id))
		{
			if(request()->popup_type == "set_file_simple")
				$file_view = View::make($this->views.'.set_file_simple', [ 'file' => $file, 'popup_type'=>request()->popup_type, 'holder_attr'=>request()->holder_attr, 'type'=>request()->type, 'title'=>request()->title, 'id' =>request()->media_id]);
			else
				$file_view = View::make($this->views.'.set_file', [ 'file' => $file, 'popup_type'=>request()->popup_type, 'holder_attr'=>request()->holder_attr, 'related_id'=>request()->related_id, 'type'=>request()->type, 'title'=>request()->title, 'id' =>request()->media_id , 'display'=>request()->display]);
	        $file_html = $file_view->render();

	        return response()->json(['success'=>1, 'html'=>$file_html]);
		}
		return response()->json(['success'=>0]);
	}

	public function editor_upload(HttpRequest $request)
    {

        if($request->hasFile('upload')) {

            $originName = $request->file('upload')->getClientOriginalName();

            $fileName = pathinfo($originName, PATHINFO_FILENAME);

            $extension = $request->file('upload')->getClientOriginalExtension();

            $fileName = $fileName.'_'.time().'.'.$extension;

        	$json = [];

            if($request->file('upload')->move(public_path('uploads/editor'), $fileName))
            {
            	$url = asset('uploads/editor/'.$fileName); 
            	$json["uploaded"]=true;
				$json["url"]=$url;
            }
            else{
            	$json["uploaded"]=false;
				$json["error"]=array("message"=>"Error Uploaded");
            }

   
            return response()->json($json);

        }

    }
}
