<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Partner;

use Illuminate\Http\Request;
use View, Redirect, Config;

class PartnerController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Partner;
        $this->route .= '.partners';
        $this->views .= '.partners';

        $this->permissions = ['list'=>'partner_listing', 'create'=>'partner_adding', 'edit'=>'partner_editing', 'delete'=>'partner_deleting'];
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

}
