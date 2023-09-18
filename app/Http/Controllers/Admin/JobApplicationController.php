<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use Illuminate\Http\Request;

use App\Models\JobApplication;
use View,Redirect, DB;

class JobApplicationController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new JobApplication;
        $this->route .= '.job-applications';
        $this->views .= '.job_applications';

        $this->permissions = ['list'=>'job_application_listing', 'create'=>'', 'edit'=>'job_application_closing', 'delete'=>'job_application_deleting'];
        $this->resourceConstruct();

    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $collection = $this->getCollection();
            if(request()->get('data'))
            {
                $collection = $this->applyFiltering($collection);
            }
            else
                $collection->where('job_applications.status', 'Open');
            return $this->setDTData($collection)->make(true);
        } else {
            
            $search_settings = $this->getSearchSettings();
            return view::make($this->views . '.index', array('search_settings'=>$search_settings));
        }
    }

    protected function getCollection() {
        return DB::table('job_applications')->select('job_applications.id', 'job_applications.name', 'email', 'phone_number', 'careers.name as job', 'job_applications.status', 'job_applications.created_at', 'job_applications.updated_at')->join('careers', 'careers.id', '=', 'job_applications.careers_id');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->orderColumn('date', function ($query, $order) {
                     $query->orderBy('created_at', $order);
            })
            ->editColumn('status', function($obj) use($route) { 
                if($obj->status == 'Open')
                {
                    return '<span class="badge text-warning">Open</span>';
                }
                elseif($obj->status == 'Processing')
                {
                    return '<span class="badge text-primary">Processing</span>';
                }
                elseif($obj->status == 'Selected')
                {
                    return '<span class="badge text-success">Selected</span>';
                }
                else{
                    return '<span class="badge text-danger">Rejected</span>';
                }
            })
            ->addColumn('action_edit', function($obj) use ($route) { 
                return '<a href="'.route($route.'.show', [encrypt($obj->id)]).'" class="text-info" title="' . ($obj->updated_at ? 'Last updated at : ' . date('d/m/Y - h:i a', strtotime($obj->updated_at)) : ''). '" ><i class="fas fa-eye"></i></a>';
            })
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    public function update(Request $r)
    {
        $data = $r->all();
        $id = decrypt($data['id']);
        if($obj = $this->model->find($id)){
            $obj->update($data);

            return Redirect::to(route($this->route.'.show', array('id'=>encrypt($obj->id))))->withSuccess('Application details successfully updated!');
        } else {
            return Redirect::back()
                        ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                        ->withInput(Input::all());
        }
    }

    protected function getSearchSettings(){
        $filter = [];
        $jobs = DB::table('careers')->select('name', 'id')->get();
        $filter['jobs'] = $jobs;
        return $filter;
    }

}
