<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as Controller;
use Illuminate\Http\Request;
use App\Models\PackageSchedule;
use DB;

class PackageScheduleController extends Controller
{

    public function index($id)
    {
        $schedules = PackageSchedule::where('package_id', $id)->orderBy('priority')->orderBy('id', 'DESC')->get();

        $obj = new PackageSchedule;
        return view('admin.package_schedules.index')->with('obj', $obj)->with('schedules', $schedules)->with('package_id', $id);
    }

    public function create($id)
    {
        $obj = new PackageSchedule;
        return view('admin.package_schedules.form')->with('obj', $obj)->with('package_id', $id);
    }

    public function edit($id)
    {
        $id = decrypt($id);
        $obj = PackageSchedule::find($id);
        return view('admin.package_schedules.form')->with('obj', $obj)->with('package_id', $obj->package_id);
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $last = PackageSchedule::select('id')->where('package_id', $data['package_id'])->orderBy('id', 'DESC')->first();
        $data['icon_image_id'] = $data['schedule_icon_image_id'];
        $data['featured_image_id'] = $data['schedule_featured_image_id'];
        $obj = new PackageSchedule;
        $obj->fill($data);
        $obj->save();

        $schedules = PackageSchedule::where('package_id', $obj->package_id)->orderBy('priority')->orderBy('id', 'DESC')->get();

        $list_html = view('admin.package_schedules.list')->with('schedules', $schedules)->render();
        $form_html = view('admin.package_schedules.form')->with('obj', $obj)->with('package_id', $obj->package_id)->render();

        return response()->json(['success'=>true, 'message'=>'Schedule successfully saved!', 'list_html'=>$list_html, 'form_html'=>$form_html]);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = decrypt($data['id']);
        if($obj = PackageSchedule::find($id)){
            $data['icon_image_id'] = $data['schedule_icon_image_id'];
            $data['featured_image_id'] = $data['schedule_featured_image_id'];
            $obj->update($data);
            
            $schedules = PackageSchedule::where('package_id', $obj->package_id)->orderBy('priority')->orderBy('id', 'DESC')->get();

            $list_html = view('admin.package_schedules.list')->with('schedules', $schedules)->render();
            $form_html = view('admin.package_schedules.form')->with('obj', $obj)->with('package_id', $obj->package_id)->render();

            return response()->json(['message'=>'Schedule successfully updated!', 'list_html'=>$list_html, 'form_html'=>$form_html]);
        } else {
            return $this->store($request);
        }
    }

    public function destroy($id)
    {
        $id = decrypt($id);
        if($obj = PackageSchedule::find($id)){
            $obj->forceDelete();
            return response()->json(['success'=>true, 'message'=>'Schedule successfully deleted!']);
        }
        else
            return response()->json(['success'=>false, 'message'=>'Oops, something wrong happend!']);
    }

    public function order_store(Request $request)
    {
        $data = $request->all();
        $order = $data['ids'];
        foreach ($order as $key => $value) {
            DB::table('package_schedules')->where('id', $value)->update(['priority' => $key]);
        }
        $response = response()->json(['success'=>'Schedule successfully re-ordered!']);
        return $response;
    }

}