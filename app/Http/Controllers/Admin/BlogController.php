<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use view, Redirect;

class BlogController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Blog;
        $this->route .= '.blogs';
        $this->views .= '.blogs';

        $this->permissions = ['list'=>'blog_listing', 'create'=>'blog_adding', 'edit'=>'blog_editing', 'delete'=>'blog_deleting'];
        $this->resourceConstruct();

    }
    
    protected function getCollection() {
        return $this->model->select('id', 'slug', 'name', 'title', 'status', 'priority', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->rawColumns(['action_edit', 'action_delete', 'status']);
    }

    protected function getSearchSettings(){}

    public function create()
    {
        $categories = Category::where('parent_id',0)->where('category_type', 'Blog')->get();
        $tags = Tag::all();
        return view::make($this->views . '.form', array('obj'=>$this->model, 'categories'=>$categories, 'tags'=>$tags));
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $categories = Category::where('parent_id',0)->where('category_type', 'Blog')->get();
            $tags = Tag::all();
            return view($this->views . '.form')->with('obj', $obj)->with('categories', $categories)->with('tags', $tags);
        } else {
            return $this->redirect('notfound');
        }
    }

    public function store()
    {
        $this->model->validate();
        $data = request()->all();
        $data['status'] = isset($data['status'])?1:0;
        $data['is_featured'] = isset($data['is_featured'])?1:0;
        $data['published_on'] = !empty($data['published_on'])?$this->parse_date_time($data['published_on']):date('Y-m-d H:i:s');
        if(empty($data['priority'])){
            $last = $this->model->select('id')->orderBy('id', 'DESC')->first();
            $data['priority'] = ($last)?$last->id+1:1;
        }
        $this->model->fill($data);
        if($this->model->save())
        {
            if(!empty($data['tags']))
                $this->model->tags()->attach($data['tags']);
        }
        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Blog successfully saved!');
    }

    public function update()
    {
        $data = request()->all();
        $id = decrypt($data['id']);
        $this->model->validate(request()->all(), $id);
         if($obj = $this->model->find($id)){
            $data['status'] = isset($data['status'])?1:0;
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $data['published_on'] = !empty($data['published_on'])?$this->parse_date_time($data['published_on']):date('Y-m-d H:i:s');
            if($obj->update($data))
            {
                if(!empty($data['tags']))
                    $obj->tags()->sync($data['tags']);
            }

            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Blog successfully updated!');
        } else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
    }
}
