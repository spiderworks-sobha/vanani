<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Tag;

use Illuminate\Http\Request;
use View, Redirect, Config;

class TagController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Tag;
        $this->route .= '.tags';
        $this->views .= '.tags';

        $this->permissions = ['list'=>'tag_listing', 'create'=>'tag_adding', 'edit'=>'tag_editing', 'delete'=>'tag_deleting'];
        $this->resourceConstruct();

    }
    
    protected function getCollection() {
        return $this->model->select('id', 'slug', 'name', 'status', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

}
