<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;
use App\Models\Menu, View, Redirect, DB, Datatables, Config;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
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

        $this->model = new Menu;

        $this->route .= '.menus';
        $this->views .= '.menus';

        $this->permissions = ['list'=>'menu_listing', 'create'=>'menu_adding', 'edit'=>'menu_editing', 'delete'=>'menu_deleting'];

        $this->resourceConstruct();

    }



    protected function getCollection() {
        return $this->model->select('id', 'name', 'position', 'status', 'created_at', 'updated_at');
        
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $obj->menu_items = $this->menu_tree($id, 0);
            return view($this->views . '.form', ['obj'=>$obj]);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store()
    {
        $this->model->validate();
        $data = request()->all();
        //print_r($data);
        $this->model->fill($data);
        $this->model->save();
        $menu_settings = json_decode($data['menu_settings']);
        if(isset($data['menu']))
            $this->store_recurssion($menu_settings, $data['menu'], 0, $this->model->id);
        return Redirect::to(route($this->route.'.edit', ['id'=>encrypt($this->model->id)]))->withSuccess('Menu successfully added!');
    }

    public function store_recurssion($menu_settings, $menu, $parent=0, $menu_id)
    {
        if($menu_settings)
        {
            foreach ($menu_settings as $key => $setting) {
                $id = $setting->id;
                if(isset($menu[$id]))
                {
                    $item_array = explode('-', $id);
                    $obj = new MenuItem;
                    $obj->menu_id = $menu_id;

                    if($item_array[0] == 'custom_link')
                    {
                        $obj->url = $menu[$id]['url'];
                        if(isset($menu[$id]['target_blank']))
                            $obj->target_blank = 1;
                        $obj->original_title = $menu[$id]['original_title'];
                    }
                    else{
                        $config_menu = Config('admin.menu.items');
                        foreach($config_menu as $config_item)
                        {
                            if(method_exists($config_item['model'], 'create_admin_menu')){
                                if($item_array[0] == $config_item['identifier'].'_link')
                                {
                                    $obj->linkable_type = $config_item['model'];                     
                                    $obj->linkable_id = $menu[$id]['id'];

                                    break;
                                }
                            }
                        }
                                                    
                    }
                    $obj->title = $menu[$id]['text'];
                    $obj->image_url = $menu[$id]['image_url'];
                    $obj->icon_class = $menu[$id]['icon'];
                    $obj->menu_order = $key;
                    $obj->menu_type = $item_array[0];
                    $obj->parent_id = $parent;
                    $obj->menu_nextable_id = $menu[$id]['menu_nextable_id'];
                    $obj->save();
                    if(isset($setting->children))
                        $this->store_recurssion($setting->children, $menu, $obj->id, $menu_id);
                }
            }
        }
    }


    public function menu_tree($menu_id, $parent)
    {
        $items = MenuItem::where('menu_id', $menu_id)->where('parent_id', $parent)->orderBy('menu_order')->get();
        if($items)
        {
            foreach ($items as $key => $item) {
                if($item->children())
                {
                    $item['children'] = $this->menu_tree($menu_id, $item->id);
                }
            }
        }
        return $items;
    }

    public function update() {
        $data = request()->all();
        $id =  decrypt($data['id']);
        $this->model->validate($data, $id);
        if($obj = $this->model->find($id)){
            $obj->update($data);
            MenuItem::where('menu_id', $obj->id)->forcedelete();
            $menu_settings = json_decode($data['menu_settings']);
            if(isset($data['menu']))
                $this->store_recurssion($menu_settings, $data['menu'], 0, $obj->id);
            return Redirect::to(route($this->route.'.edit', ['id'=>encrypt($obj->id)]))->withSuccess('Menu successfully updated!');
        }
        else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(Input::all());
        }
    }
}
