<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\Amenity as AdminAmenity;
use App\Traits\ResourceTrait;
use App\Models\Amenity;
use Redirect;

class AmenityController extends Controller
{
    use ResourceTrait;
    
    public function __construct()
    {
        parent::__construct();
    
        $this->model = new Amenity;
        $this->route .= '.amenities';
        $this->views .= '.amenities';
        
        $this->permissions = ['list'=>'amenity_listing', 'create'=>'amenity_adding', 'edit'=>'amenity_editing', 'delete'=>'amenity_deleting'];
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'name', 'status', 'priority', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) 
    {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}


    public function store(AdminAmenity $request)
    {
        $request->validated();
        $data = $request->all();
        $data['status'] = isset($data['status'])?1:0;
        $data['is_featured'] = isset($data['is_featured'])?1:0;
        $data['priority'] = !empty($data['priority'])?$data['priority']:0;
        $this->model->fill($data);
        $this->model->save();

        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Amenity successfully saved!');
    }

    public function update(AdminAmenity $request)
    {
        $request->validated();
        $data = $request->all();
        $id =  decrypt($data['id']);
        if($obj = $this->model->find($id)){
            $data['status'] = isset($data['status'])?1:0;
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $data['priority'] = !empty($data['priority'])?$data['priority']:0;
            $obj->update($data);
            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Amenity successfully updated!');
        }
        else 
        {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
            
    }
}
