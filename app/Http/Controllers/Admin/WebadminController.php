<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Input, View, Validator, Redirect, Auth, DB, Session, Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Widget;
use App\Models\User;
use App\Events\LoginHistory;
use App\Models\Setting;

class WebadminController extends Controller {

    public function __construct(){
        $this->middleware('permission:widgets', ['only' => ['widgets','save_widget']]);
    }
	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('admin.index');
	}

	public function login()
	{
		if(Auth::guard('admin')->user())
		{
            $admin_url = Config::get('admin.url_prefix').'/dashboard';
			return Redirect::to($admin_url);
		}
		else{
			return view('admin.login');
		}
	}

    public function google_login(Request $request){
        $id_token = $request->credential;
        $google_client_id = Setting::where('code', 'google_auth_client_id')->value('value_text');
        $guzzleClient = new \GuzzleHttp\Client(array( 'curl' => array( CURLOPT_SSL_VERIFYPEER => false, ), ));
        $client = new \Google\Client();
        $client->setClientId($google_client_id);
        $client->setHttpClient($guzzleClient);
        $payload = $client->verifyIdToken($id_token);
        if ($payload) {
            if(empty($payload['email']))
                return Redirect::back()->withErrors('Invalid Login');
            $email = $payload['email'];
            $user = User::where('email', $email)->where('status', 1)->first();
            if(!$user)
                return Redirect::back()->withErrors('Invalid Login');
            Auth::guard('admin')->login($user);
            event(new LoginHistory(['email'=>$email], 'admin'));
            $request->session()->regenerate();
            $admin_url = Config::get('admin.url_prefix').'/dashboard';
            return redirect()->intended($admin_url);

        } else {
            return Redirect::back()->withErrors('Invalid Login');
        }
    }

    public function select2_faq(Request $request)
    {
        $items = DB::table('faqs')->where('name', 'like', $request->q.'%')->orderBy('name')
            ->get();
        $json = [];
        foreach($items as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->name];
        }
        return \Response::json($json);
    }

    public function select2_products(Request $request)
    {
        $items = DB::table('products')->where('name', 'like', $request->q.'%')->orderBy('name')
            ->get();
        $json = [];
        foreach($items as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->name];
        }
        return \Response::json($json);
    }

    public function select2_categories($type=null)
    {
        $items = DB::table('categories')->where('name', 'like', request()->q.'%');
        if($type)
            $items->where('category_type', $type);
        
        $items = $items->orderBy('name')->get();
        $json = [];
        foreach($items as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->name];
        }
        return \Response::json($json);
    }

    public function select2_list(Request $request)
    {
        $items = DB::table('listings')->where('listing_name', 'like', $request->q.'%')->orderBy('listing_name')
            ->get();
        $json = [];
        foreach($items as $c){
            $json[] = ['id'=>$c->id, 'text'=>$c->listing_name];
        }
        return \Response::json($json);
    }

    public function unique_roles(Request $request)
    {
        $id = $request->id;
        $name = $request->name;
         
        $where = "name='".$name."'";
        if($id)
            $where .= " AND id != ".decrypt($id);
        $obj = DB::table('roles')
                    ->whereRaw($where)
                    ->get();
         
        if (count($obj)>0) {  
             echo "false";
        } else {  
             echo "true";
        }
    }

    public function unique_users(Request $request)
    {
        $id = $request->id;
        $email = $request->email;
         
        $where = "email='".$email."'";
        if($id)
            $where .= " AND id != ".decrypt($id);
        $obj = DB::table('admins')
                    ->whereRaw($where)
                    ->whereNull('deleted_at')
                    ->get();
         
        if (count($obj)>0) {  
             echo "false";
        } else {  
             echo "true";
        }
    }

	public function unique_slug(Request $request)
    {
         $id = $request->id;
         $slug = $request->slug;
         $table = $request->table;
         
         $where = "slug='".$slug."'";
         if($id)
            $where .= " AND id != ".decrypt($id);
         $result = DB::table($table)
                    ->whereRaw($where)
                    ->whereNull('deleted_at')
                    ->get();
         
         if (count($result)>0) {  
             echo "false";
         } else {  
             echo "true";
         }
    }
	
	public function changePassword(Request $request){
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current_password'), $request->get('new_pwd')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
        $validatedData = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:6',
            'new_confirm_password' => ['same:new_password'],
        ]);

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
        return redirect()->back()->with("success","Password changed successfully !");
    }

    public function widgets()
    {
        $widgets = Widget::all();
        $data = [];
        foreach ($widgets as $key => $value) {
            $data[$value->code] = (array) json_decode($value->content);
        }
        return view('admin.widgets', ['data'=>$data]);
    }

    public function save_widget(Request $request)
    {
        $data = $request->all();
        if($obj = Widget::find($data['id']))
        {
            $obj->content = json_encode($data['section']);
            $obj->save();
            return Redirect::to(url('sw-admin/widgets'))->withSuccess('Widget successfully updated!');
        }
        return Redirect::back()
                        ->withErrors("Ooops..Something wrong happend.Please try again.") // send back all errors to the login form
                        ->withInput($data);
    }

}
