<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Comment;

use Illuminate\Http\Request;
use View, Redirect, Config;

class CommentController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Comment;
        $this->route .= '.comments';
        $this->views .= '.comments';

        $this->permissions = ['list'=>'comment_listing', 'create'=>'comment_reply', 'edit'=>'comment_editing', 'delete'=>'comment_deleting'];
        $this->resourceConstruct();

    }
    
    protected function getCollection() {
        return $this->model->select('id', 'name', 'email', 'comment', 'status', 'created_at', 'updated_at');
    }

    protected function setDTData($collection) {
        $route = $this->route;
        return $this->initDTData($collection)
            ->addColumn('action_reply', function($obj) use ($route) { 
                if(auth()->user()->can($this->permissions['create']))
                    return '<a href="'.route($route.'.create', [encrypt($obj->id)]).'" class="text-info webadmin-open-ajax-popup" title="Reply" ><i class="fas fa-reply"></i></a>';
                else
                    return '<a href="javascript:void(0)" class="text-secondary" title="You have no permission to reply" ><i class="fas fa-reply"></i></a>';
            })
            ->addColumn('action_delete_comment', function($obj) use ($route) { 
                $has_child = $this->model->where('parent_id', '=', $obj->id)->count();
                if($has_child)
                {
                    return '<a href="javascript:void(0);" class= "text-danger delete_have_child" title="Created at : ' . date('d/m/Y - h:i a', strtotime($obj->created_at)) . '" > <i class="fa fa-trash"></i></button>';
                }
                else{
                     return '<a href="' . route( $route . '.destroy',  [encrypt($obj->id)] ) . '" class="text-danger webadmin-btn-warning-popup" data-message="Are you sure to delete?  Associated data will be removed if it is deleted." title="' . ($obj->updated_at ? 'Last updated at : ' . date('d/m/Y - h:i a', strtotime($obj->updated_at)) : '') . '" ><i class="fa fa-trash"></i></a>';  
                }
            })
            ->rawColumns(['action_edit', 'action_delete_comment', 'status', 'action_reply']);
    }

    protected function getSearchSettings(){}

    public function create($parent)
    {
        $id = decrypt($parent);
        $parent = $this->model->find($id);
        return view::make($this->views . '.form', array('obj'=>$this->model, 'parent'=>$parent));
    }

    public function store()
    {
        $data = request()->all();
        $parent_id = decrypt($data['id']);
        $parent = $this->model->find($parent_id);
        $data['name'] = auth()->user()->name;
        $data['parent_id'] = $parent_id;
        $data['parent_levels_id'] = ($parent->parent_levels_id == 0)?$parent_id:$parent->parent_levels_id;
        $data['linkable_type'] = $parent->linkable_type;
        $data['linkable_id'] = $parent->linkable_id;
        $data['status'] = 1;
        $this->model->fill($data);
        $this->model->save();
        return response()->json(['success'=>'Reply successfully saved']);
    }

}