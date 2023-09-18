<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\QuickTask;

class QuickTaskController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new QuickTask;
        $this->route .= '.quick-tasks';
        $this->views .= '.quick_tasks';

        $this->permissions = ['list'=>'quick_task_listing', 'create'=>'quick_task_adding', 'edit'=>'quick_task_editing', 'delete'=>'quick_task_deleting'];
        $this->resourceConstruct();

    }
    
    protected function getCollection() {
        return $this->model->select('id', 'title', 'status', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('status', function($obj) use($route) { 
                if($obj->status == 'Open')
                {
                    return '<span class="badge badge-danger">Open</span>';
                }
                else{
                    return '<span class="badge badge-success">Close</span>';
                }
            })
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

}
