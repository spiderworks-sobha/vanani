<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use App\Traits\ResourceTrait;

use App\Models\Event;
use App\Models\EventMedia;
use App\Models\Category;
use Illuminate\Http\Request;

use View, Redirect;

class EventController extends Controller
{
    use ResourceTrait;

    public function __construct()
    {
        parent::__construct();

        $this->model = new Event;
        $this->route .= '.events';
        $this->views .= '.events';

        $this->permissions = ['list'=>'event_listing', 'create'=>'event_adding', 'edit'=>'event_editing', 'delete'=>'event_deleting'];
        $this->resourceConstruct();

    }
    
    protected function getCollection() {
        return $this->model->select('id', 'slug', 'name', 'priority', 'status', 'created_at', 'updated_at');
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
        return view::make($this->views . '.form', array('obj'=>$this->model, 'categories'=>$categories));
    }

    public function edit($id) {
        $id = decrypt($id);
        if($obj = $this->model->find($id)){
            $categories = Category::where('parent_id',0)->where('category_type', 'Blog')->get();
            return view($this->views . '.form')->with('obj', $obj)->with('categories', $categories);
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
        $data['start_time'] = !empty($data['start_time'])?$this->parse_date_time($data['start_time']):null;
        $data['end_time'] = !empty($data['end_time'])?$this->parse_date_time($data['end_time']):null;
        if(empty($data['priority'])){
            $last = $this->model->select('id')->orderBy('id', 'DESC')->first();
            $data['priority'] = ($last)?$last->id+1:1;
        }
        $this->model->fill($data);
        if($this->model->save())
        {
            if(isset($data['event_medias']))
                foreach ($data['event_medias'] as $key => $value) {
                    if(trim($value) != '')
                    {
                        $event_media = new EventMedia;
                        $event_media->upload_type = 'Upload';
                        $event_media->media_id = $value;
                        $this->model->gallery()->save($event_media);
                    }
                }

            if(isset($data['youtube_url']))
                foreach ($data['youtube_url'] as $key => $value) {
                    if(trim($value) != '')
                    {
                        $event_media = new EventMedia;
                        $event_media->upload_type = 'Youtube';
                        $event_media->youtube_url = $value;
                        $event_media->youtube_preview = $data['youtube_preview'][$key];
                        $this->model->gallery()->save($event_media);
                    }
                }
        }
        return Redirect::to(route($this->route. '.edit', ['id'=> encrypt($this->model->id)]))->withSuccess('Event successfully saved!');
    }

    public function update()
    {
        $data = request()->all();
        $id = decrypt($data['id']);
        $this->model->validate(request()->all(), $id);
         if($obj = $this->model->find($id)){
            $data['status'] = isset($data['status'])?1:0;
            $data['is_featured'] = isset($data['is_featured'])?1:0;
            $data['start_time'] = !empty($data['start_time'])?$this->parse_date_time($data['start_time']):null;
            $data['end_time'] = !empty($data['end_time'])?$this->parse_date_time($data['end_time']):null;
            if($obj->update($data))
            {
                if(isset($data['event_medias']))
                    foreach ($data['event_medias'] as $key => $value) {
                        if(trim($value) != '')
                        {
                            $event_media = new EventMedia;
                            $event_media->upload_type = 'Upload';
                            $event_media->media_id = $value;
                            $obj->gallery()->save($event_media);
                        }
                    }

                if(isset($data['youtube_url']))
                    foreach ($data['youtube_url'] as $key => $value) {
                        if(trim($value) != '')
                        {
                            $event_media = new EventMedia;
                            $event_media->upload_type = 'Youtube';
                            $event_media->youtube_url = $value;
                            $event_media->youtube_preview = $data['youtube_preview'][$key];
                            $obj->gallery()->save($event_media);
                        }
                    }
            }

            return Redirect::to(route($this->route. '.edit', ['id'=>encrypt($id)]))->withSuccess('Event successfully updated!');
        } else {
            return Redirect::back()
                    ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                    ->withInput(request()->all());
        }
    }

    public function media_edit($id, $type){
        $id = decrypt($id);
		if($file = EventMedia::find($id))
		{
			return view($this->views.'.media_form', array('file'=>$file, 'type'=>$type));
		}
    }

    public function media_update(Request $request){
        $data = $request->all();
        $id = decrypt($data['gallery_media_id']);
        if($obj = EventMedia::find($id)){
            if(!empty($data['media_id']))
            {
                $obj->media_id = $data['media_id'];
                if($obj->upload_type == "Youtube")
                    $obj->youtube_preview = NULL;
            }
            $obj->title = $data['media_title'];
            $obj->description = $data['media_description'];
            $obj->save();

            $type = "Image-Video";
            $file_view = View::make($this->views.'.media', [ 'item' => $obj, 'type'=>$type]);
            $file_html = $file_view->render();
            return response()->json(['success'=>1, 'html'=>$file_html, 'id'=>$obj->id]);

        } else {
            return $this->redirect('notfound');
        }
    }

    public function media_destroy($id){
        $id = decrypt($id);
		if($file = EventMedia::find($id))
		{
            $file->delete();
            return response()->json(['success'=>1]);
		}
    }

    
}
