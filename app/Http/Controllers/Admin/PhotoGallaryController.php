<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\PhotoGallary;
use App\Models\PhotoGallaryPhoto;
use App\Models\Media;
use Illuminate\Http\Request as HttpRequest;

use Request, View, Redirect, DB, Datatables, Mail, Image, File AS FileInput;

class PhotoGallaryController extends Controller
{
    use ResourceTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->model = new PhotoGallary;

        $this->route .= '.photo-galleries';
        $this->views .= '.photo_galleries';

        $this->permissions = ['list'=>'photo_gallery_listing', 'create'=>'photo_gallery_adding', 'edit'=>'photo_gallery_editing', 'delete'=>'photo_gallery_deleting'];

        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'gallery_name', 'created_at', 'updated_at');
        
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete']);
    }

    protected function getSearchSettings(){}

    public function edit($id, $type="slider") {
        $id =  decrypt($id);
        if($obj = $this->model->find($id)){
            return view($this->views . '.form')->with('obj', $obj)->with('type', $type);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store(HttpRequest $request)
    {
        $this->model->validate();
        $data = $request->all();
        $this->model->fill($data);
        $this->model->save();

        return Redirect::to(route($this->route. '.edit', array('id'=>encrypt($this->model->id))))->withSuccess('Slider successfully created!');
    }

    public function photo_edit($id, $gallery_id, $type)
    {
        if($photo = PhotoGallaryPhoto::find($id))
        {
            $slider = PhotoGallary::where('id', $gallery_id)->first();
            return view($this->views.'.photo_edit', array('photo'=>$photo, 'slider'=>$slider, 'type'=>$type));
        }
    }

    public function update(HttpRequest $request)
    {
        $data = $request->all();
        $id = decrypt($data['id']);
        if($obj = $this->model->find($id)){
            if(isset($data['ids']))
            {
                foreach ($data['ids'] as $key => $value) {
                    $value = decrypt($value);
                    $photo = new PhotoGallaryPhoto;
                    $photo->media_id = $value;
                    $obj->photos()->save($photo);
                }
                return view($this->views.'.ajax_photos', array('photos'=>$obj->photos, 'gallery'=>$obj->id));
            }
            else{
                $obj->update($data);
                return Redirect::to(route($this->route. '.edit', array('id'=>encrypt($obj->id))))->withSuccess('Gallery successfully updated!');
            }
            
        } else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(Input::all());
        }
    }

    public function updatePhoto(HttpRequest $request)
    {
        $data = $request->all();
        $id = decrypt($data['id']);
        if($photo_obj = PhotoGallaryPhoto::find($id)){
            $obj = $this->model->find($photo_obj->photo_galleries_id);
            $photo_obj->fill($data);
            $photo_obj->save();
            return Redirect::to(route($this->route. '.edit', array('id'=>encrypt($obj->id))))->withSuccess('Gallery successfully updated!');
        } else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(Input::all());
        }
    }

    public function photo_delete($gallery_id, $id, $type)
    {
        if($photo_obj = PhotoGallaryPhoto::find($id)){
            $photo_obj->forcedelete();
            if(Request::ajax())
                return $response = response()->json(['success'=>'Gallery successfully updated!']);
            else
                return Redirect::to(route($this->route. '.edit', array('id'=>encrypt($slider_id))))->withSuccess('Gallery successfully updated!');
        }
        if (Request::ajax())
            return $response = response()->json(['error'=>'Oops!! something went wrong...Please try again.']);
        else
            return Redirect::back()->withErrors("Ooops..Something wrong happend.Please try again.");
    }

    public function destroy($id) {
        $obj = $this->model->find($id);
        if ($obj) {
            $obj->forcedelete();
            return Redirect::to(route($this->route. '.index'))->withSuccess('Slider successfully deleted!');
        }
        
        return Redirect::back()->withErrors("Ooops..Something wrong happend.Please try again.");
    }

    public function validate_name()
    {
        $id = request()->id;
        $gallery_name = request()->gallery_name;
         
        $where = "gallery_name='".$gallery_name."'";
        if($id)
            $where .= " AND id != ".decrypt($id);
        $result = DB::table('photo_galleries')
                    ->whereRaw($where)
                    ->get();
         
        if (count($result)>0) {  
             echo "false";
        } else {  
             echo "true";
        }
    }

}
