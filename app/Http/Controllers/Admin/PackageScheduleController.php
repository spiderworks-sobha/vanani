<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\PackageScheduleRequest;
use App\Models\Package;
use Illuminate\Http\Request;
use App\Models\PackageSchedule;
use App\Traits\ResourceTrait;
use Redirect, View;

class PackageScheduleController extends Controller
{

    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new PackageSchedule;
        $this->route .= '.packages.schedule';
        $this->views .= '.package_schedules';

        $this->permissions = ['list'=>'package_listing', 'create'=>'package_adding', 'edit'=>'package_adding', 'delete'=>'package_adding'];
        $this->resourceConstruct();

    }

    public function index(Request $request, $id)
    {
        if ($request->ajax()) {
            $collection = $this->getCollection();
            $collection->where('package_id', $id);
            return $this->setDTData($collection)->make(true);
        } else {
            $search_settings = $this->getSearchSettings();
            $package = Package::find($id);
            if(!$package)
                return abort('404');
            return view::make($this->views . '.index', array('search_settings'=>$search_settings, 'package'=>$package));
        }
    }
    
    protected function getCollection() {
        return $this->model->select('id', 'title', 'priority', 'status', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

    public function create($id)
    {
        $package = Package::find($id);
        if(!$package)
            return abort('404');
        return view::make($this->views . '.form', array('obj'=>$this->model, 'package'=>$package));
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $package = Package::find($obj->package_id);
            if(!$package)
                return abort('404');
            return view($this->views . '.form')->with('obj', $obj)->with('package', $package);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store(PackageScheduleRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $data['status'] = isset($data['status'])?1:0;
        $data['priority'] = !empty($data['priority'])?$data['priority']:0;
        $this->model->fill($data);
        if($this->model->save()){
            $data['activity_to'] = !empty($data['activity_to'])?$data['activity_to']:[];
            $this->saveActivities($this->model, $data['activity_to']);
        }
        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Package schedule successfully saved!');
    }

    protected function saveActivities($package, $activities=[]): void
    {
        $activity_array = [];
        if($activities)
            foreach($activities as $key=>$activity){
                $activity_array[$activity] = ['priority'=>$key, 'created_by'=>auth()->user()->id, 'updated_by'=>auth()->user()->id, 'created_at'=>date('Y-m-d H:i:s')];
            }
        $package->activities()->sync($activity_array);
    }

    public function update(PackageScheduleRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $id =  decrypt($data['id']);
        if($obj = $this->model->find($id)){
            $data['status'] = isset($data['status'])?1:0;
            $data['priority'] = !empty($data['priority'])?$data['priority']:0;
            if($obj->update($data)){
                $data['activity_to'] = !empty($data['activity_to'])?$data['activity_to']:[];
                $this->saveActivities($obj, $data['activity_to']);
            }
            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Package schedule successfully updated!');
        }
        else 
        {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
    }

}