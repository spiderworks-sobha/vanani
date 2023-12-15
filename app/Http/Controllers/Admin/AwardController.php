<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\AwardRequest;
use App\Traits\ResourceTrait;
use App\Models\Award;

class AwardController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Award;
        $this->route .= '.awards';
        $this->views .= '.awards';

        $this->permissions = ['list'=>'award_listing', 'create'=>'award_adding', 'edit'=>'award_editing', 'delete'=>'award_deleting'];
        $this->resourceConstruct();

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

    public function store(AwardRequest $request){
        $request->validated();
        return $this->_store($request->all());
    }

    public function update(AwardRequest $request)
    {
        $request->validated();
        return $this->_update(decrypt($request->id), $request->all());
    }

}
