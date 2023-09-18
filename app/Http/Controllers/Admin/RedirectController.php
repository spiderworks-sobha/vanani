<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\Http\Request as HttpRequest;
use App\Traits\ResourceTrait;

use App\Models\Redirect as HtaccessRedirect;
use View,Redirect, DB;

class RedirectController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new HtaccessRedirect;
        $this->route = 'admin.redirects';
        $this->views = 'admin.redirects';
        $this->permissions = ['list'=>'301_redirects_listing', 'create'=>'301_redirects_adding', 'edit'=>'', 'delete'=>'301_redirects_deleting'];
        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'redirect_from', 'redirect_to', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete']);
    }

    protected function getSearchSettings(){}

    public function create()
    {
        return view($this->views . '.form')->with('obj', $this->model)->with('tab', 'basic');
    }

    public function store(HttpRequest $r)
    {
        $data = $r->all();
        //print_r($data);exit;
        foreach($data['redirect_from'] as $key=> $from)
        {
            if(trim($from) != '')
            {
                $obj = new HtaccessRedirect;
                $obj->redirect_from = trim($from, '/');
                $obj->redirect_to = $data['redirect_to'][$key];
                $obj->save();
            }
        }
        return Redirect::to(route('admin.redirects.index'))->withSuccess('301 redirections successfully saved!'); 
    }

}
