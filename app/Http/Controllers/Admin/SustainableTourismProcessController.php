<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\SustainableTourismProcessRequest;
use App\Traits\ResourceTrait;
use App\Models\SustainableTourismProcess;
use Redirect;

class SustainableTourismProcessController extends Controller
{
    use ResourceTrait;
    
    public function __construct()
    {
        parent::__construct();
    
        $this->model = new SustainableTourismProcess;
        $this->route .= '.sustainable-tourism-processes';
        $this->views .= '.sustainable_tourism_processes';
        
        $this->permissions = ['list'=>'sustainable_tourism_process_listing', 'create'=>'sustainable_tourism_process_adding', 'edit'=>'sustainable_tourism_process_editing', 'delete'=>'sustainable_tourism_process_deleting'];
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'title', 'status', 'priority', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) 
    {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}


    public function store(SustainableTourismProcessRequest $request)
    {
        $request->validated();
        $data = $request->all();
        return $this->_store($data);
    }

    public function update(SustainableTourismProcessRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $id =  decrypt($data['id']);
        return $this->_update($id, $data);
    }
}
