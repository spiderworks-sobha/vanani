<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;
use Illuminate\Http\Request as HttpRequest;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use View, Redirect, Validator, Request, DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Admin;
        $this->route = 'admin.users';
        $this->views = 'admin.users';

        $this->permissions = ['list'=>'user_listing', 'create'=>'user_adding', 'edit'=>'user_editing', 'delete'=>'user_deleting'];

        $this->resourceConstruct();

    }
    
    protected function getCollection() {
        return $this->model->select('id', 'name', 'email', 'status', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

    public function create()
    {
        $roles = Role::all();
        return view($this->views . '.form')->with('obj', $this->model)->with('roles', $roles);
    }

    public function edit($id) {
        $id =  decrypt($id);
        if($obj = $this->model->find($id)){
            $roles = Role::all();
            return view($this->views . '.form')->with('obj', $obj)->with('roles', $roles);
        } else {
            return $this->redirect('notfound');
        }
    }
    public function store(HttpRequest $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => 'required|max:250',
            'email' => 'required|email|unique:users,email|max:250',
            'roles' => 'required'
        ]);
        if ($validator->fails()){
            if (Request::ajax())
                $response = response()->json(['errors' => $validator->errors()->all()]);
            else
                $response = Redirect::back()->withInput()->withErrors($validator->errors()->all());
            return $response;
        }
        else
        {
            $this->model->fill($data);
            if($this->model->save())
            {
                $this->model->assignRole($request->input('roles'));
            }

            if (Request::ajax())
                $response = response()->json(['success'=>'User details successfully saved!']);
            else
                $response = Redirect::to(route('admin.users.edit', array('id'=>encrypt($this->model->id))))->withSuccess('User details successfully saved!');
            return  $response;
        } 
    }

    public function update(HttpRequest $request)
    {
        $data = $request->all();
        $id = decrypt($data['id']);
        $validator = Validator::make($data, [
            'name' => 'required|max:250',
            'email' => 'required|email|max:250|unique:users,email,'.$id,
            'roles' => 'required'
        ]);
        if ($validator->fails()){
             if (Request::ajax())
                $response = response()->json(['errors' => $validator->errors()->all()]);
            else
                $response = Redirect::back()->withInput()->withErrors($validator->errors()->all());
            return $response;
        }
        else
        {
            if($obj = $this->model->find($id)){
            
                if($obj->update($data))
                {
                    DB::table('model_has_roles')->where('model_id',$id)->delete();
                    $obj->assignRole($request->input('roles'));
                }
                if (Request::ajax())
                    $response = response()->json(['success'=>'User details successfully saved!']);
                else
                    $response = Redirect::to(route('admin.users.edit', array('id'=>encrypt($obj->id))))->withSuccess('User details successfully updated!');
                return  $response; 
            } else {
                return Redirect::back()
                        ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                        ->withInput(Input::all());
            }
        }
    }

}
