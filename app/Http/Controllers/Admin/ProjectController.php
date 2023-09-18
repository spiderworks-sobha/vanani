<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Project;
use App\Models\Service;
use App\Models\ProjectImage;

use Illuminate\Http\Request;
use View, Redirect, Config;

class ProjectController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Project;
        $this->route .= '.projects';
        $this->views .= '.projects';

        $this->permissions = ['list'=>'project_listing', 'create'=>'project_adding', 'edit'=>'project_editing', 'delete'=>'project_deleting'];
        $this->resourceConstruct();

    }
    
    protected function getCollection() {
        return $this->model->select('id', 'slug', 'name', 'title', 'priority', 'status', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

    public function create()
    {
        $services = Service::where('parent_id',0)->get();
        return view::make($this->views . '.form', array('obj'=>$this->model, 'services'=>$services));
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $services = Service::where('parent_id',0)->get();
            return view($this->views . '.form')->with('obj', $obj)->with('services', $services);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store()
    {

        $this->model->validate();
        $data = request()->all();
        $data['is_featured'] = isset($data['is_featured'])?1:0;
        $data['priority'] = (isset($data['priority']) && $data['priority'])?$data['priority']:0;
        $this->model->fill($data);
        $this->model->save();

        if(isset($data['project_images']))
            foreach ($data['project_images'] as $key => $value) {
                if(trim($value) != '')
                {
                    $project_image = new ProjectImage;
                    $project_image->media_id = $value;
                    $this->model->images()->save($project_image);
                }
            }

        return Redirect::to(route('admin.projects.edit', ['id'=>encrypt($this->model->id)]))->withSuccess('Project successfully added!');
    }

    public function update()
    {
        $data = request()->all();
        $id = decrypt($data['id']);
        $this->model->validate(request()->all(), $id);
        if($obj = $this->model->find($id)){
            $data = request()->all();
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $data['priority'] = (isset($data['priority']) && $data['priority'])?$data['priority']:0;
            $obj->update($data);
            ProjectImage::where('projects_id', $obj->id)->forcedelete();
            
            if(isset($data['project_images']))
                foreach ($data['project_images'] as $key => $value) {
                    if(trim($value) != '')
                    {
                        $project_image = new ProjectImage;
                        $project_image->media_id = $value;
                        $obj->images()->save($project_image);
                    }
                }

            return Redirect::to(route('admin.projects.edit', ['id'=>encrypt($id)]))->withSuccess('Project successfully updated!');

        } else {

            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }

    }
}
