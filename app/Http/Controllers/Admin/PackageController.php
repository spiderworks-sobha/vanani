<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\Package as AdminPackage;
use App\Traits\ResourceTrait;
use App\Models\Package;
use App\Models\Tag;
use Redirect;

class PackageController extends Controller
{
    use ResourceTrait;
    
    public function __construct()
    {
        parent::__construct();
    
        $this->model = new Package;
        $this->route .= '.packages';
        $this->views .= '.packages';
        
        $this->permissions = ['list'=>'package_listing', 'create'=>'package_adding', 'edit'=>'package_editing', 'delete'=>'package_deleting'];
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'slug', 'name', 'status', 'show_on_offer', 'priority', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) 
    {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('show_on_offer', function($obj) use($route) { 
                if($obj->show_on_offer == 1)
                {
                    return '<i class="h5 text-success fa fa-check-circle"></i>';
                }
                else{
                    if(auth()->user()->can($this->permissions['edit']))
                        return '<a href="' . route($route.'.show-on-offer', [encrypt($obj->id)]) . '" class="webadmin-btn-warning-popup" data-message="Are you sure, want to enable this record to show in offer section?"><i class="h5 text-danger fa fa-times-circle"></i></a>';
                    else
                        return '<i class="h5 text-danger fa fa-times-circle"></i>';
                }
            })
            ->rawColumns(['action_edit', 'action_delete', 'status', 'show_on_offer']);
    }

    protected function getSearchSettings(){}

    public function create()
    {
        $tags = Tag::all();
        return view($this->views . '.form', array('obj'=>$this->model, 'tags'=>$tags));
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $tags = Tag::all();
            return view($this->views . '.form')->with('obj', $obj)->with('tags', $tags);
        } else {
            return $this->redirect('notfound');
        }
    }


    public function store(AdminPackage $request)
    {
        $request->validated();
        $data = $request->all();
        $data['status'] = isset($data['status'])?1:0;
        $data['is_featured'] = isset($data['is_featured'])?1:0;
        $data['priority'] = !empty($data['priority'])?$data['priority']:0;
        $this->model->fill($data);
        if($this->model->save()){
            $data['attraction_to'] = !empty($data['attraction_to'])?$data['attraction_to']:[];
            $data['activity_to'] = !empty($data['activity_to'])?$data['activity_to']:[];
            $data['tags'] = !empty($data['tags'])?$data['tags']:[];
            $this->saveAttractions($this->model, $data['attraction_to']);
            $this->saveActivities($this->model, $data['activity_to']);
            $medias = (!empty($data['package_media']))?$data['package_media']:[];
            $this->savePackageMedia($this->model, $medias);
            $this->saveTags($this->model, $data['tags']);
        }

        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Package successfully saved!');
    }

    protected function saveAttractions($package, $attractions=[]): void
    {
        $attraction_array = [];
        if($attractions)
            foreach($attractions as $key=>$attraction){
                $attraction_array[$attraction] = ['priority'=>$key, 'created_by'=>auth()->user()->id, 'updated_by'=>auth()->user()->id, 'created_at'=>date('Y-m-d H:i:s')];
            }
        $package->attractions()->sync($attraction_array);
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

    protected function saveTags($package, $tags=[]): void
    {
        $tag_array = [];
        if($tags)
            foreach($tags as $key=>$tag){
                $tag_array[$tag] = ['created_by'=>auth()->user()->id, 'updated_by'=>auth()->user()->id, 'created_at'=>date('Y-m-d H:i:s')];
            }
        $package->tags()->sync($tag_array);
    }

    protected function savePackageMedia($package, $medias=[]): void
    {
        $media_array = [];
        if($medias)
            foreach($medias as $key=>$media){
                if(!empty($media))
                    $media_array[$media] = ['created_by'=>auth()->user()->id, 'updated_by'=>auth()->user()->id, 'created_at'=>date('Y-m-d H:i:s')];
            }
        $package->medias()->attach($media_array);
    }

    public function update(AdminPackage $request)
    {
        $request->validated();
        $data = $request->all();
        $id =  decrypt($data['id']);
        if($obj = $this->model->find($id)){
            $data['status'] = isset($data['status'])?1:0;
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $data['priority'] = !empty($data['priority'])?$data['priority']:0;
            if($obj->update($data)){
                $data['attraction_to'] = !empty($data['attraction_to'])?$data['attraction_to']:[];
                $data['activity_to'] = !empty($data['activity_to'])?$data['activity_to']:[];
                $data['tags'] = !empty($data['tags'])?$data['tags']:[];
                $this->saveAttractions($obj, $data['attraction_to']);
                $this->saveActivities($obj, $data['activity_to']);
                $medias = (!empty($data['rental_media']))?$data['rental_media']:[];
                $this->savePackageMedia($obj, $medias);
                $this->saveTags($obj, $data['tags']);
            }
            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Package successfully updated!');
        }
        else 
        {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
            
    }

    public function showOnOffer($id){
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            Package::where('show_on_offer', 1)->update(['show_on_offer'=>0]);
            $obj->show_on_offer = 1;
            $obj->save();
            return response()->json(['success'=> 'Success']);
        }
        return $this->redirect('notfound');
    }
}
