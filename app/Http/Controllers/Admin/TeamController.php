<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use Illuminate\Http\Request as HttpRequest;

use App\Models\Team;
use App\Models\Department;
use View,Redirect, DB;

class TeamController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Team;
        $this->route .= '.team';
        $this->views .= '.team';

        $this->permissions = ['list'=>'team_listing', 'create'=>'team_adding', 'edit'=>'team_editing', 'delete'=>'team_deleting'];
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'name', 'slug', 'designation', 'priority', 'status', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

    public function create()
    {
        $departments = Department::get();
        return view($this->views . '.form')->with('obj', $this->model)->with('tab', 'basic')->with('departments', $departments);
    }

    public function edit($id, $tab="basic") {
        $id =  decrypt($id);
        if($obj = $this->model->find($id)){
            $departments = Department::get();
            return view($this->views . '.form')->with('obj', $obj)->with('tab', $tab)->with('departments', $departments);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store(HttpRequest $r)
    {
        $data = $r->all();
        $this->model->validate();

        if($data['department_id'])
        {
            $department = Department::find($data['department_id']);
            if(!$department){
                $new_department = New Department;
                $new_department->name = $data['department_id'];
                $new_department->save();
                $data['department_id'] = $new_department->id;
            }
        }
        $data['is_featured'] = isset($data['is_featured'])?1:0;
        $data['status'] = isset($data['status'])?1:0;
        if(empty($data['priority'])){
            $last = $this->model->select('id')->orderBy('id', 'DESC')->first();
            $data['priority'] = ($last)?$last->id+1:1;
        }
        $this->model->fill($data);
        $this->model->save();
        return Redirect::to(route($this->route.'.edit', array('id'=>encrypt($this->model->id))))->withSuccess('Team member successfully saved!'); 
    }

    public function update(HttpRequest $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){
            if($data['department_id'])
            {
                $department = Department::find($data['department_id']);
                if(!$department){
                    $new_department = New Department;
                    $new_department->name = $data['department_id'];
                    $new_department->save();
                    $data['department_id'] = $new_department->id;
                }
            }
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $data['status'] = isset($data['status'])?1:0;
            $data['priority'] = (isset($data['priority']) && $data['priority'])?$data['priority']:0;
            $obj->update($data);

            return Redirect::to(route($this->route.'.edit', array('id'=>encrypt($obj->id))))->withSuccess('Team member details successfully updated!');
        } else {
            return Redirect::back()
                        ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                        ->withInput(Input::all());
        }
    }

}
