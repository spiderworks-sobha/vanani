<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use Haruncpi\LaravelUserActivity\Models\Log;
use App\Models\Category;

class LogController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Log;
        $this->route .= '.logs';
        $this->views .= '.logs';

        $this->permissions = ['list'=>'log_listing', 'create'=>'', 'edit'=>'', 'delete'=>'log_deleting'];
        $this->resourceConstruct();

    }
    
    protected function getCollection() {
        return $this->model->select('logs.id', 'users.name', 'table_name', 'log_type', 'log_date')->leftJoin('users', 'logs.user_id', '=', 'users.id');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->editColumn('date', function($obj){
                return date('d M, Y h:i A', strtotime($obj->log_date));
            })
            ->addColumn('action_edit', function($obj) use ($route) { 
                return '<a href="'.route($route.'.show', [encrypt($obj->id)]).'" class="text-info webadmin-open-ajax-popup" data-popup-size="large" title="View Details" ><i class="fas fa-eye"></i></a>';     
            })
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

    public function show($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            return view($this->views . '.view')->with('obj', $obj);
        } else {
            return $this->redirect('notfound');
        }
    }
}
