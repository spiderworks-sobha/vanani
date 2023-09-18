<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Slider;
use App\Models\SliderPhoto;
use App\Models\Media;
use Illuminate\Http\Request as HttpRequest;

use Request, View, Redirect, DB, Datatables, Mail, Image, File AS FileInput;

class SliderController extends Controller
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

        $this->model = new Slider;

        $this->route .= '.sliders';
        $this->views .= '.sliders';

        $this->permissions = ['list'=>'slider_listing', 'create'=>'slider_adding', 'edit'=>'slider_editing', 'delete'=>'slider_deleting'];

        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'slider_name', 'width', 'height', 'created_at', 'updated_at');
        
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

    public function photo_edit($id, $slider_id, $type)
    {
        if($photo = SliderPhoto::find($id))
        {
            $slider = Slider::where('id', $slider_id)->first();
            $crop_ratio =  ($slider->width)/($slider->height);
            return view($this->views.'.photo_edit', array('photo'=>$photo, 'slider'=>$slider, 'crop_ratio'=>$crop_ratio, 'type'=>$type));
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
                    $photo = new SliderPhoto;
                    $photo->media_id = $value;
                    $obj->photos()->save($photo);
                }
                return view($this->views.'.ajax_photos', array('photos'=>$obj->photos, 'slider'=>$obj->id));
            }
            else{
                $obj->update($data);
                return Redirect::to(route($this->route. '.edit', array('id'=>encrypt($obj->id))))->withSuccess('Slider successfully updated!');
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
        if($photo_obj = SliderPhoto::find($id)){
            $data['meta_data'] = json_encode($data['content']);
            $photo_obj->fill($data);
            $photo_obj->save();
            return Redirect::to(route($this->route. '.edit', array('id'=>encrypt($photo_obj->sliders_id))))->withSuccess('Slider successfully updated!');
        } else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(Input::all());
        }
    }

    public function photo_delete($slider_id, $id, $type)
    {
        if($photo_obj = SliderPhoto::find($id)){
            $photo_obj->forcedelete();
            if(Request::ajax())
                return $response = response()->json(['success'=>'Slider successfully updated!']);
            else
                return Redirect::to(route($this->route. '.edit', array('id'=>encrypt($slider_id))))->withSuccess('Slider successfully updated!');
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
        $slider_name = request()->slider_name;
         
        $where = "slider_name='".$slider_name."'";
        if($id)
            $where .= " AND id != ".decrypt($id);
        $result = DB::table('sliders')
                    ->whereRaw($where)
                    ->get();
         
        if (count($result)>0) {  
             echo "false";
        } else {  
             echo "true";
        }
    }

    public function update_order(HttpRequest $request){
        $data = $request->all();
        foreach($data['ids'] as $key=>$id){
            $photo = SliderPhoto::find($id);
            $photo->priority = $key;
            $photo->save();
        }
        return $response = response()->json(['success'=>'Sliders successfully reordered!']);
    }

}
