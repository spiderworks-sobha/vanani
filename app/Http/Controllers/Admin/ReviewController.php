<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\Review as AdminReview;
use App\Models\Accommodation;
use App\Models\Package;
use App\Models\Rental;
use App\Traits\ResourceTrait;
use App\Traits\FileUpload;

use App\Models\Review;

use Illuminate\Http\Request;
use View, Redirect;

class ReviewController extends Controller
{
    use ResourceTrait, FileUpload;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Review;
        $this->route .= '.reviews';
        $this->views .= '.reviews';

        $this->permissions = ['list'=>'review_listing', 'create'=>'review_adding', 'edit'=>'review_editing', 'delete'=>'review_deleting'];
        $this->resourceConstruct();

    }

    public function index(Request $request, $type, $id)
    {
        if ($request->ajax()) {
            $collection = $this->getCollection();
            $type_model = $this->getReviewableModel($type);
            $collection->where('reviewable_type', $type_model)->where('reviewable_id', $id);
            return $this->setDTData($collection)->make(true);
        } else {
            $search_settings = $this->getSearchSettings();
            $reviewable = $this->getReviewable($type, $id);
            if(!$reviewable)
                return abort('404');
            return view::make($this->views . '.index', array('type'=>$type, 'search_settings'=>$search_settings, 'reviewable'=>$reviewable));
        }
    }
    
    protected function getCollection() {
        return $this->model->select('id', 'name', 'priority', 'status', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

    protected function getReviewableModel($type){
        $reviewable_model = null;
        switch ($type) {
            case 'accommodations':
                $reviewable_model = 'App\\Models\\Accommodation';
                break;
            
            case 'rentals':
                $reviewable_model = 'App\\Models\\Rental';
                break;

            case 'packages':
                $reviewable_model = 'App\\Models\\Package';
                break;
        }
        return $reviewable_model;
    }

    protected function getReviewableType($type){
        $reviewable_type = null;
        switch ($type) {
            case 'App\Models\Accommodation':
                $reviewable_type = 'accommodations';
                break;
            
            case 'App\Models\Rental':
                $reviewable_type = 'rentals';
                break;

            case 'App\Models\Package':
                $reviewable_type = 'packages';
                break;
        }
        return $reviewable_type;
    }

    protected function getReviewable($type, $id){
        $reviewable = null;
        switch ($type) {
            case 'accommodations':
                $reviewable = Accommodation::find($id);
                break;
            
            case 'rentals':
                $reviewable = Rental::find($id);
                break;

            case 'packages':
                $reviewable = Package::find($id);
                break;
        }
        return $reviewable;
    }

    public function create($type, $id)
    {
        $reviewable = $this->getReviewable($type, $id);
        if(!$reviewable)
                return abort('404');
        return view::make($this->views . '.form', array('obj'=>$this->model, 'type'=>$type, 'reviewable'=>$reviewable));
    }

    public function store(AdminReview $request)
    {
        $request->validated();
        $data = $request->all();
        if($request->hasFile('image') && $request->file('image')->isValid())
            $data['photo'] = $this->fileUpload($request->file('image'), 'reviews/photos');

        if($data['review_type'] == "Video"){
            if($request->hasFile('video_review') && $request->file('video_review')->isValid())
                $data['review'] = $this->fileUpload($request->file('video_review'), 'reviews/videos');
        }
        else{
            $data['review'] = $data['text_review'];
        }
        $data['reviewable_type'] = $this->getReviewableModel($data['type']);
        $data['reviewable_id'] = $data['reviewable_model_id'];
        $data['status'] = isset($data['status'])?1:0;
        if(empty($data['priority'])){
            $last = $this->model->select('id')->orderBy('id', 'DESC')->first();
            $data['priority'] = ($last)?$last->id+1:1;
        }
        $this->model->fill($data);
        $this->model->save();
        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Review successfully saved!');
    }

    public function edit($id) {
    	$id = decrypt($id);
        if($obj = $this->model->find($id)){
            $type = $this->getReviewableType($obj->reviewable_type);
            $reviewable = $this->getReviewable($type, $obj->reviewable_id);
            if(!$reviewable)
                return abort('404');
            return view($this->views . '.form')->with('obj', $obj)->with('type', $type)->with('reviewable', $obj->reviewable);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function update(AdminReview $request)
    {
        $request->validated();
    	$data = $request->all();
        
    	$id = decrypt($data['id']);
         if($obj = $this->model->find($id)){
            if(!empty($data['is_photo_removed']))
                $data['photo'] = null;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                if($obj->photo)
                    @unlink(public_path($obj->photo));
                $data['photo'] = $this->fileUpload($request->file('image'), 'reviews/photos');
            }

            if($data['review_type'] == "Video"){
                if($request->hasFile('video_review') && $request->file('video_review')->isValid()){
                    @unlink(public_path($obj->review));
                    $data['review'] = $this->fileUpload($request->file('video_review'), 'reviews/videos');
                }
            }
            else{
                @unlink(public_path($obj->review));
                $data['review'] = $data['text_review'];
            }
            $data['priority'] = !empty($data['priority'])?$data['priority']:0;
            $data['status'] = isset($data['status'])?1:0;
            $obj->update($data);

            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Review successfully updated!');
        } else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
    }
}
