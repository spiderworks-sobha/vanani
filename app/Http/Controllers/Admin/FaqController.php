<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use Illuminate\Support\Facades\Hash;
use View, Redirect, Validator, DB;

class FaqController extends Controller
{

    public function index($id, $type)
    {
        $model_type = "App\Models\\".$type;
        $list = new $model_type;
        $faq = $list->find($id)->faq;

        $obj = new Faq;
        $obj->linkable_type = $model_type;
        $obj->linkable_id = $id;
        return view('admin.faq.index')->with('obj', $obj)->with('faq', $faq)->with('type', $type);
    }

    public function create($id, $type)
    {
        $model_type = "App\Models\\".$type;
        $obj = new Faq;
        $obj->linkable_type = $model_type;
        $obj->linkable_id = $id;
        return view('admin.faq.form')->with('obj', $obj)->with('type', $type);
    }

    public function edit($id, $type)
    {
        $id = decrypt($id);
        $obj = Faq::find($id);
        return view('admin.faq.form')->with('obj', $obj)->with('type', $type);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $last = Faq::select('id')->orderBy('id', 'DESC')->first();
        $data['display_order'] = ($last)?$last->id+1:1;
        $obj = new Faq;
        $obj->fill($data);
        $obj->save();

        $list = new $obj->linkable_type;
        $faq = $list->find($obj->linkable_id)->faq;

        $list_html = view('admin.faq.list')->with('faq', $faq)->with('type', $data['type'])->render();
        $form_html = view('admin.faq.form')->with('obj', $obj)->with('type', $data['type'])->render();

        return response()->json(['success'=>true, 'message'=>'FAQ successfully saved!', 'list_html'=>$list_html, 'form_html'=>$form_html]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = decrypt($data['id']);
        if($obj = Faq::find($id)){
            $obj->update($data);
            
            $list = new $obj->linkable_type;
            $faq = $list->find($obj->linkable_id)->faq;

            $list_html = view('admin.faq.list')->with('faq', $faq)->with('type', $data['type'])->render();
            $form_html = view('admin.faq.form')->with('obj', $obj)->with('type', $data['type'])->render();

            return response()->json(['message'=>'FAQ successfully updated!', 'list_html'=>$list_html, 'form_html'=>$form_html]);
        } else {
            return $this->store($request);
        }
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        if($obj = Faq::find($id)){
            $obj->forceDelete();
            return response()->json(['success'=>true, 'message'=>'FAQ successfully deleted!']);
        }
        else
            return response()->json(['success'=>false, 'message'=>'Oops, something wrong happend!']);
    }

    public function order_store(Request $request)
    {
        $data = $request->all();
        $order = $data['ids'];
        foreach ($order as $key => $value) {
            DB::table('faq_question_answers')->where('id', $value)->update(['display_order' => $key]);
        }
        $response = response()->json(['success'=>'Faqs successfully re-ordered!']);
        return $response;
    }

}