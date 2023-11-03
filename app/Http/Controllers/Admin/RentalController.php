<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\Activity as AdminActivity;
use App\Traits\ResourceTrait;
use App\Models\Rental;
use App\Models\Tag;
use Redirect;

class RentalController extends Controller
{
    use ResourceTrait;
    
    public function __construct()
    {
        parent::__construct();
    
        $this->model = new Rental;
        $this->route .= '.rentals';
        $this->views .= '.rentals';
        
        $this->permissions = ['list'=>'rental_listing', 'create'=>'rental_adding', 'edit'=>'rental_editing', 'delete'=>'rental_deleting'];
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'slug', 'name', 'status', 'priority', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) 
    {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
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


    public function store(AdminActivity $request)
    {
        $request->validated();
        $data = $request->all();
        $data['status'] = isset($data['status'])?1:0;
        $data['is_featured'] = isset($data['is_featured'])?1:0;
        if(empty($data['priority'])){
            $last = $this->model->select('id')->orderBy('id', 'DESC')->first();
            $data['priority'] = ($last)?$last->id+1:1;
        }
        $this->model->fill($data);
        if($this->model->save()){
            $this->saveAmenities($this->model, $data['amenity_to']);
            $this->saveActivities($this->model, $data['activity_to']);
            $medias = (!empty($data['rental_media']))?$data['rental_media']:[];
            $this->saveRentalMedia($this->model, $medias);
            $this->saveTags($this->model, $data['tags']);
        }

        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Rental successfully saved!');
    }

    protected function saveAmenities($rental, $amenities=[]): void
    {
        $aminity_array = [];
        if($amenities)
            foreach($amenities as $key=>$aminity){
                $aminity_array[$aminity] = ['priority'=>$key, 'created_by'=>auth()->user()->id, 'updated_by'=>auth()->user()->id, 'created_at'=>date('Y-m-d H:i:s')];
            }
        $rental->amenities()->sync($aminity_array);
    }

    protected function saveActivities($rental, $activities=[]): void
    {
        $activity_array = [];
        if($activities)
            foreach($activities as $key=>$activity){
                $activity_array[$activity] = ['priority'=>$key, 'created_by'=>auth()->user()->id, 'updated_by'=>auth()->user()->id, 'created_at'=>date('Y-m-d H:i:s')];
            }
        $rental->activities()->sync($activity_array);
    }

    protected function saveRentalMedia($rental, $medias=[]): void
    {
        $media_array = [];
        if($medias)
            foreach($medias as $key=>$media){
                if(!empty($media))
                    $media_array[$media] = ['created_by'=>auth()->user()->id, 'updated_by'=>auth()->user()->id, 'created_at'=>date('Y-m-d H:i:s')];
            }
        $rental->medias()->sync($media_array);
    }

    protected function saveTags($rental, $tags=[]): void
    {
        $tag_array = [];
        if($tags)
            foreach($tags as $key=>$tag){
                $tag_array[$tag] = ['created_by'=>auth()->user()->id, 'updated_by'=>auth()->user()->id, 'created_at'=>date('Y-m-d H:i:s')];
            }
        $rental->tags()->sync($tag_array);
    }

    public function update(AdminActivity $request)
    {
        $request->validated();
        $data = $request->all();
        $id =  decrypt($data['id']);
        if($obj = $this->model->find($id)){
            $data['status'] = isset($data['status'])?1:0;
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $data['priority'] = !empty($data['priority'])?$data['priority']:0;
            if($obj->update($data)){
                $this->saveAmenities($obj, $data['amenity_to']);
                $this->saveActivities($obj, $data['activity_to']);
                $medias = (!empty($data['rental_media']))?$data['rental_media']:[];
                $this->saveRentalMedia($obj, $medias);
                $this->saveTags($obj, $data['tags']);
            }
            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Rental successfully updated!');
        }
        else 
        {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
            
    }
}
