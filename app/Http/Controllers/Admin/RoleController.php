<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Role;
use App\Models\Permission;

use Illuminate\Http\Request as Reqst;
use Request, View, Redirect, DB, Image, Validator;

class RoleController extends Controller
{
    use ResourceTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->model = new Role;

        $this->route .= '.roles';
        $this->views .= '.roles';

        $this->permissions = ['list'=>'role_listing', 'create'=>'role_adding', 'edit'=>'role_editing', 'delete'=>'role_deleting'];

        $this->resourceConstruct();

    }

    protected function getCollection() {
        return $this->model->select('id', 'name', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete']);
    }

    protected function getSearchSettings(){}

    public function create()
    {
        $permissions = Permission::where('public', 1)->get();
        return view($this->views . '.form')->with('obj', $this->model)->with('r_permissions', $permissions);
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $permissions = Permission::where('public', 1)->get();
            return view($this->views . '.form')->with('obj', $obj)->with('r_permissions', $permissions);
        } else {
            return $this->redirect('notfound');
        }
    }


    public function store(Reqst $request)
    {
        $data = $request->all();
        $this->model->validate();
        $this->model->fill($data);
        if($this->model->save())
        {
            if(isset($data['permissions']))
            {
                foreach ($data['permissions'] as $key => $value) {
                    DB::table('role_has_permissions')->insert(['role_id'=>$this->model->id, 'permission_id'=>$value]);
                }
            }
        }
        $this->clear_cache();
        return Redirect::to(route('admin.roles.edit', array('id'=>encrypt($this->model->id))))->withSuccess('Role successfully saved!');
    }

    public function update(Reqst $request)
    {
        $data = $request->all();
        $id = decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){
            if($obj->update($data))
            {
                DB::table('role_has_permissions')->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')->where('role_has_permissions.role_id', $obj->id)->where('permissions.public', 1)->delete();
                if(isset($data['permissions']))
                {
                    foreach ($data['permissions'] as $key => $value) {
                        DB::table('role_has_permissions')->insert(['role_id'=>$obj->id, 'permission_id'=>$value]);
                    }
                }
            }
            $this->clear_cache();
            return Redirect::to(route('admin.roles.edit', array('id'=>encrypt($obj->id))))->withSuccess('Role successfully updated!');
        } else {
            return Redirect::back()
                        ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                        ->withInput(Input::all());
        }
    }

}
