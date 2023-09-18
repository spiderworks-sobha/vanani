<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Services\MailSettings;
use App\Mail\Admin\RequestOtp;
use App\Traits\ClientInfoTrait;
use App\Events\LoginHistory;
use Validator;

class AuthController extends Controller
{
    use ClientInfoTrait;
    public function login(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|max:190|email',
        ]);
        if ($validator->fails()){
            return response()->json(['success'=>false, 'errors' => $validator->errors()->all()], 400);
        }

        $admin = Admin::where('email', $request->email)->first();
        if(!$admin)
            return response()->json(['success'=>false, 'error' => 'This email is not registered with us.'], 401);
        else{
            if($admin->status == 0)
                return response()->json(['success'=>false, 'error' => 'This account is suspended.'], 401);
            else{
                if($admin->account_blocked_on){
                    $account_blocked_on = new \DateTime($admin->account_blocked_on);
                    $now = new \DateTime("now");
                    $interval = abs($account_blocked_on->getTimestamp() - $now->getTimestamp()) / 60;
                    if($interval <= 10){
                        return response()->json(['success'=>false, 'error' => 'This account is temporarily suspended due to suspicious activity.'], 475);
                    }
                    else{
                        $admin->opt_try_count = 0;
                        $admin->account_blocked_on = null;
                        $admin->account_blocked_ip = null;
                    }
                }

                $otp = rand(111111,999999);
                $admin->otp = $otp;
                $admin->otp_sent_on = date('Y-m-d H:i:s');
                $admin->save();

                $mail = new MailSettings;
        		$mail->to($admin->email)->send(new RequestOtp($admin->name, $admin->otp));

                $data = ['id'=>$admin->id];

                return response()->json(['success'=>true, 'data'=>$data, 'message'=>'Otp has been successfully sent to your mail address']);

            }
        }
    }

    public function verify_otp(Request $request){

        $data = $request->all();
        $validator = Validator::make($data, [
            'otp' => 'required|numeric|digits:6',
        ]);
        if ($validator->fails()){
            return response()->json(['success'=>false, 'errors' => $validator->errors()->all()], 400);
        }

        
        $admin = Admin::where('id', $data['id'])->first();
        if(!$admin)
            return response()->json(['success'=>false, 'error' => 'This email is not registered with us.'], 401);

        if($admin->status == 0)
            return response()->json(['success'=>false, 'error' => 'This account is suspended.'], 401);

        if($admin->opt_try_count == 3){
            $admin->account_blocked_on = date('Y-m-d H:i:s');
            $admin->account_blocked_ip = $this->get_ip();
            $admin->save();
            return response()->json(['success'=>false, 'error' => 'This account is temporarily suspended due to suspicious activity.'], 475);
        }

        if($admin->otp != $data['otp']){
            $admin->opt_try_count = $admin->opt_try_count+1;
            $admin->save();
            return response()->json(['success'=>false, 'error' => 'Invalid Otp.'], 400);
        }

        $otp_sent_on = new \DateTime($admin->login_otp_sent_on);
        $now = new \DateTime("now");
        $interval = abs($otp_sent_on->getTimestamp() - $now->getTimestamp()) / 60;
        if($interval > 10){
            return response()->json(['success'=>false, 'error' => 'Otp Expired.'], 400);
        }
        $admin->last_login_ip_address = $this->get_ip();
        $admin->save();
        event(new LoginHistory(['email'=>$admin->email], 'admin'));
        
        $token = $admin->createToken('auth_token')->plainTextToken;
        $data = [];
        $data['user'] = $admin;
        $data['token'] = $token;

        return response()->json(['success'=>true, 'data'=>$data, 'message'=>'User successfully verified']);

    }
}
