<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\Activity as AdminActivity;
use App\Traits\ResourceTrait;
use App\Models\Activity;
use Redirect;

class ActivityController extends Controller
{
    use ResourceTrait;
    
    public function __construct()
    {
        parent::__construct();
    
        $this->model = new Activity;
        $this->route .= '.activities';
        $this->views .= '.activities';
        
        $this->permissions = ['list'=>'activity_listing', 'create'=>'activity_adding', 'edit'=>'activity_editing', 'delete'=>'activity_deleting'];
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


    public function store(AdminActivity $request)
    {
        $request->validated();
        $data = $request->all();
        $data['status'] = isset($data['status'])?1:0;
        if(empty($data['priority'])){
            $last = $this->model->select('id')->orderBy('id', 'DESC')->first();
            $data['priority'] = ($last)?$last->id+1:1;
        }
        $this->model->fill($data);
        $this->model->save();

        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Activity successfully saved!');
    }

    public function update(AdminActivity $request)
    {
        $request->validated();
        $data = $request->all();
        $id =  decrypt($data['id']);
        if($obj = $this->model->find($id)){
            $data['status'] = isset($data['status'])?1:0;
            $data['priority'] = !empty($data['priority'])?$data['priority']:0;
            $obj->update($data);
            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Activity successfully updated!');
        }
        else 
        {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
            
    }
}
