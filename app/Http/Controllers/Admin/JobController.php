<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use Illuminate\Http\Request as HttpRequest;

use App\Models\Job;
use App\Models\Department;
use View,Redirect, DB;

class JobController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Job;
        $this->route .= '.jobs';
        $this->views .= '.jobs';

        $this->permissions = ['list'=>'job_listing', 'create'=>'job_adding', 'edit'=>'job_editing', 'delete'=>'job_deleting'];
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('careers.*', 'departments.name as department')->leftJoin('departments', 'departments.id', '=', 'careers.departments_id');
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

        if($data['departments_id'])
        {
            $department = Department::find($data['departments_id']);
            if(!$department){
                $new_department = New Department;
                $new_department->name = $data['departments_id'];
                $new_department->save();
                $data['departments_id'] = $new_department->id;
            }
        }
        if(empty($data['priority'])){
            $last = $this->model->select('id')->orderBy('id', 'DESC')->first();
            $data['priority'] = ($last)?$last->id+1:1;
        }
        $data['is_featured'] = isset($data['is_featured'])?1:0;
        $data['last_application_date'] = (trim($data['last_application_date'])!= '')?date('Y-m-d', strtotime($data['last_application_date'])):'';
        $this->model->fill($data);
        $this->model->save();
        return Redirect::to(route($this->route.'.edit', array('id'=>encrypt($this->model->id))))->withSuccess('Job successfully saved!'); 
    }

    public function update(HttpRequest $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){
            if($data['departments_id'])
            {
                $department = Department::find($data['departments_id']);
                if(!$department){
                    $new_department = New Department;
                    $new_department->name = $data['departments_id'];
                    $new_department->save();
                    $data['departments_id'] = $new_department->id;
                }
            }
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $data['last_application_date'] = (trim($data['last_application_date'])!= '')?date('Y-m-d', strtotime($data['last_application_date'])):'';
            $obj->update($data);

            return Redirect::to(route($this->route.'.edit', array('id'=>encrypt($obj->id))))->withSuccess('Job successfully updated!');
        } else {
            return Redirect::back()
                        ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                        ->withInput(Input::all());
        }
    }

    public function validate_job_code()
    {
        $id = request()->id;
        $job_code = request()->job_code;
         
        $where = "job_code='".$job_code."'";
        if($id)
            $where .= " AND id != ".decrypt($id);
        $result = DB::table('careers')
                    ->whereRaw($where)
                    ->get();
         
        if (count($result)>0) {  
             echo "false";
        } else {  
             echo "true";
        }
    }

}
