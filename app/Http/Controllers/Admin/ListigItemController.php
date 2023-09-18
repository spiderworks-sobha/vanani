<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Listing;
use App\Models\ListingContent;
use Redirect;

class ListigItemController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new ListingContent;
        $this->route .= '.listing-items';
        $this->views .= '.listing_items';

        $this->permissions = ['list'=>'listing_listing', 'create'=>'listing_adding', 'edit'=>'listing_editing', 'delete'=>'listing_deleting'];
        $this->resourceConstruct();

    }

    public function index($listing_id)
    {
        if (request()->ajax()) {
            $collection = $this->getCollection();
            $collection->where('listings_id', $listing_id);
            return $this->setDTData($collection)->make(true);
        } else {
            $search_settings = $this->getSearchSettings();
            $listing = Listing::find($listing_id);
            return view($this->views . '.index')->with('listing', $listing)->with('search_settings', $search_settings);
        }
    }

    protected function getCollection() {
        return $this->model->select('listing_contents.id', 'listing_contents.title', 'listing_contents.meida_type', 'medias.file_path', 'listing_contents.icon', 'listing_contents.status', 'listing_contents.priority', 'listing_contents.created_at', 'listing_contents.updated_at')
                            ->leftJoin('medias', 'medias.id', '=', 'listing_contents.media_id');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('media', function($obj){
                if($obj->meida_type == 'Icon')
                    return $obj->icon;
                elseif($obj->meida_type == 'Image')
                    return '<a href="'.asset($obj->file_path).'" target="_blank"><img src="'.asset($obj->file_path).'" style="width:20px"/></a>';
                else
                    return '';
            })
            ->rawColumns(['action_edit', 'action_delete', 'status', 'media']);
    }

    public function create($listing_id)
    {
        $listing = Listing::find($listing_id);
        if(!$listing)
            return abort('404');
        return view($this->views . '.form')->with('obj', $this->model)->with('listing', $listing);
    }

    public function edit($id) {
        $id =  decrypt($id);
        if($obj = $this->model->find($id)){
            $listing = Listing::find($obj->listings_id);
            return view($this->views . '.form')->with('obj', $obj)->with('listing', $listing);
        } else {
            return $this->redirect('notfound');
        }
    }

    protected function getSearchSettings(){}

    public function store()
    {
        $this->model->validate();
        $data = request()->all();
        $data['status'] = isset($data['status'])?1:0;
        if($data['meida_type'] == 'Icon'){
            $data['media_id'] = null;
        }
        elseif($data['meida_type'] == 'Image'){
            $data['icon'] = null;
        }
        else{
            $data['media_id'] = null;
            $data['icon'] = null;
        }
        if(empty($data['priority'])){
            $last = $this->model->select('id')->orderBy('id', 'DESC')->first();
            $data['priority'] = ($last)?$last->id+1:1;
        }
        $this->model->fill($data);
        $this->model->save();

        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Listing item successfully saved!');
    }

    public function update()
    {
        $data = request()->all();
        $id =  decrypt($data['id']);
        if($obj = $this->model->find($id)){
            $data['status'] = isset($data['status'])?1:0;
            if($data['meida_type'] == 'Icon'){
                $data['media_id'] = null;
            }
            elseif($data['meida_type'] == 'Image'){
                $data['icon'] = null;
            }
            else{
                $data['media_id'] = null;
                $data['icon'] = null;
            }

            $data['priority'] = !empty($data['priority'])?$data['priority']:0;
            $obj->update($data);
            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Listig successfully updated!');
        }
        else 
        {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }       
    }

}