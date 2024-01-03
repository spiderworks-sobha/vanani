<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Http\Requests\Admin\CouponRequest;
use App\Traits\ResourceTrait;
use App\Models\Coupon;

class CouponController extends Controller
{
    use ResourceTrait;
    
    public function __construct()
    {
        parent::__construct();
    
        $this->model = new Coupon();
        $this->route .= '.coupons';
        $this->views .= '.coupons';
        
        $this->permissions = ['list'=>'coupon_listing', 'create'=>'coupon_adding', 'edit'=>'coupon_editing', 'delete'=>'coupon_deleting'];
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


    public function store(CouponRequest $request)
    {
        $request->validated();
        return $this->_store($request->all());
    }

    public function update(CouponRequest $request)
    {
        $request->validated();
        $data = $request->all();
        $id =  decrypt($data['id']);
        return $this->_update($id, $data);
    }
}
