<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\Attraction as AdminAttraction;
use App\Traits\ResourceTrait;
use App\Models\Attraction;

class AttractionController extends Controller
{
    use ResourceTrait;
    
    public function __construct()
    {
        parent::__construct();
    
        $this->model = new Attraction();
        $this->route .= '.attractions';
        $this->views .= '.attractions';
        
        $this->permissions = ['list'=>'attraction_listing', 'create'=>'attraction_adding', 'edit'=>'attraction_editing', 'delete'=>'attraction_deleting'];
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'name', 'status', 'priority', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) 
    {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}


    public function store(AdminAttraction $request)
    {
        $request->validated();
        return $this->_store($request->all());
    }

    public function update(AdminAttraction $request)
    {
        $request->validated();
        $data = $request->all();
        $id =  decrypt($data['id']);
        return $this->_update($id, $data);
    }
}
