<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Testimonial;

use Illuminate\Http\Request;
use View, Redirect;

class TestimonialController extends Controller
{
    use ResourceTrait;
    
    public function __construct()
    {
        parent::__construct();
       

        $this->model = new Testimonial;
        $this->route .= '.testimonials';
        $this->views .= '.testimonials';
        
        $this->permissions = ['list'=>'testimonial_listing', 'create'=>'testimonial_adding', 'edit'=>'testimonial_editing', 'delete'=>'testimonial_deleting'];
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'name', 'status', 'designation', 'priority', 'created_at', 'updated_at');
        
    }

    protected function setDTData($collection) 
    {
        $route = $this->route;
        return $this->initDTData($collection)
            
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}


    public function store()
    {
        $this->model->validate();
        $data = request()->all();
        if($data['comment_type'] == 'Text')
        {
            $data['youtube_link'] = null;
            $data['video_link_id'] = null;
        }
        elseif($data['comment_type'] == 'Youtube Video')
        {
            $data['comment'] = null;
            $data['video_link_id'] = null;
        }
        elseif($data['comment_type'] == 'Video from Computer')
        {
            $data['comment'] = null;
            $data['youtube_link'] = null;
        }
        $data['status'] = isset($data['status'])?1:0;
        $data['is_featured'] = isset($data['is_featured'])?1:0;
        if(empty($data['priority'])){
            $last = $this->model->select('id')->orderBy('id', 'DESC')->first();
            $data['priority'] = ($last)?$last->id+1:1;
        }
        $this->model->fill($data);
        $this->model->save();

        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Testimonial successfully saved!');
    }

    public function update()
    {
        $data = request()->all();
        $id =  decrypt($data['id']);
        if($obj = $this->model->find($id)){
            if($data['comment_type'] == 'Text')
	        {
	            $data['youtube_link'] = null;
	            $data['video_link_id'] = null;
	        }
	        elseif($data['comment_type'] == 'Youtube Video')
	        {
	            $data['comment'] = null;
	            $data['video_link_id'] = null;
	        }
	        elseif($data['comment_type'] == 'Video from Computer')
	        {
	            $data['comment'] = null;
	            $data['youtube_link'] = null;
	        }
            $data['status'] = isset($data['status'])?1:0;
            $data['priority'] = !empty($data['priority'])?$data['priority']:0;
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $obj->update($data);
            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Testimonial successfully updated!');
        }
        else 
        {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
            
    }
}
