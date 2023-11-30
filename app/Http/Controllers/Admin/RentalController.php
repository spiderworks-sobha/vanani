<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\Rental as AdminRental;
use App\Traits\ResourceTrait;
use App\Models\Rental;
use App\Models\Tag;
use App\Models\RentalMedia;
use Symfony\Component\HttpFoundation\Request;
use Redirect, View;

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
        return $this->model->select('id', 'slug', 'name', 'status', 'show_on_offer', 'priority', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) 
    {
        $route = $this->route;
        return $this->initDTData($collection)
            ->addColumn('reviews', function($obj){
                return '<a href="'.route('admin.reviews.index', ['rentals', $obj->id]).'" target="_blank"><i class="fas fa-eye"></i></a>';
            })
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
            ->rawColumns(['action_edit', 'action_delete', 'status', 'show_on_offer', 'reviews']);
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


    public function store(AdminRental $request)
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
            $data['amenity_to'] = !empty($data['amenity_to'])?$data['amenity_to']:[];
            $data['activity_to'] = !empty($data['activity_to'])?$data['activity_to']:[];
            $data['tags'] = !empty($data['tags'])?$data['tags']:[];
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
        if($medias){
            $media_array = [];
            foreach($medias as $key=>$media){
                if(!empty($media))
                    $media_array[$media] = ['created_by'=>auth()->user()->id, 'updated_by'=>auth()->user()->id, 'created_at'=>date('Y-m-d H:i:s')];
            }
            $rental->medias()->attach($media_array);
        }
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

    public function update(AdminRental $request)
    {
        $request->validated();
        $data = $request->all();
        $id =  decrypt($data['id']);
        if($obj = $this->model->find($id)){
            $data['status'] = isset($data['status'])?1:0;
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $data['priority'] = !empty($data['priority'])?$data['priority']:0;
            if($obj->update($data)){
                $data['amenity_to'] = !empty($data['amenity_to'])?$data['amenity_to']:[];
                $data['activity_to'] = !empty($data['activity_to'])?$data['activity_to']:[];
                $data['tags'] = !empty($data['tags'])?$data['tags']:[];
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

    public function showOnOffer($id){
        $id = decrypt($id);
        $obj = $this->model->find($id);
        if ($obj) {
            Rental::where('show_on_offer', 1)->update(['show_on_offer'=>0]);
            $obj->show_on_offer = 1;
            $obj->save();
            return response()->json(['success'=> 'Success']);
        }
        return $this->redirect('notfound');
    }

    public function media_edit($id){
        $id = decrypt($id);
		if($file = RentalMedia::find($id))
		{
			return view($this->views.'.media_form', array('file'=>$file));
		}
    }

    public function media_update(Request $request){
        $data = $request->all();
        $id = decrypt($data['rental_media_id']);
        if($obj = RentalMedia::find($id)){
            $obj->media_id = $data['media_id'];
            $obj->title = $data['media_title'];
            $obj->description = $data['media_description'];
            $obj->save();

            $file_view = View::make($this->views.'.media', [ 'item' => $obj->media, 'rental_media_id'=>$obj->id]);
            $file_html = $file_view->render();
            return response()->json(['success'=>1, 'html'=>$file_html, 'id'=>$obj->id]);

        } else {
            return $this->redirect('notfound');
        }
    }

    public function media_destroy($id){
        $id = decrypt($id);
		if($file = RentalMedia::find($id))
		{
            $file->delete();
            return response()->json(['success'=>1]);
		}
    }
}
