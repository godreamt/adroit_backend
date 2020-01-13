<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(RegisterFormRequest $request)
    {
        $user = new User;
        $user->firstName = $request->firstName;
        $user->lastName = $request->lastName;
        $user->mobileNumber = $request->mobileNumber;
        $user->address = $request->address;
        $user->roles = $request->roles;
        $user->email = $request->email; 
        $user->password = bcrypt($request->password);
        $user->save();
        return response([
            'status' => 'success',
            'data' => $user
           ], 200);
     }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ( ! $token = JWTAuth::attempt($credentials)) {
                return response([
                    'status' => 'error',
                    'error' => 'invalid.credentials',
                    'msg' => 'Invalid Credentials.'
                ], 400);
        }
        $user = \Auth::user();
        if(!$user->isActive){
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Access denied.'
            ], 400);
        }
        $customClaims=['userId'=>$user->id, 'email'=>$user->email, 'roles'=> $user->roles];
        $token = JWTAuth::fromUser(\Auth::user(), $customClaims);
        return response([
                'status' => 'success',
                'token' => $token
            ]);
    }

    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
                'status' => 'success',
                'data' => $user
            ]);
    }

    public function logout()
    {
        JWTAuth::invalidate();
        return response([
                'status' => 'success',
                'msg' => 'Logged out Successfully.'
            ], 200);
    }

    public function refresh()
    {
        return response([
         'status' => 'success'
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request){
        if(empty($request->user_id)) {
            $user_id = \Auth::user()->id;
        }else {
            $user_id = $request->user_id;
        }
         $user=User::find($user_id);
         if(password_verify ($request->oldPassword, $user->password)){
             $user->password=bcrypt($request->password);
             $user->save();
             return $user;
         }else{
             return response()->json(['errors'=>['user'=>["Old password is not valid."]]], 500);
         }
    }

    
    public function forgotVerification(OnlyEmail $request){
         $user=User::where('email','=',$request->email)->first();
         $hash="";
         $flag=true;
         while($flag):
             $hash = mt_rand(10000000, 99999999);
             $exi=User::where('reset_token','=',$hash)->first();
             if(!($exi instanceof User)){
                 $user=User::find($user->id);
                 $user->reset_token = $hash;
                 $user->save();
                //  Mail::to($user)->send(new ForgotPassword($user->firstName,$request->email, $hash));
                 $flag=false;
             }
         endwhile;
         return $user;
     }
 
     public function forgotPasswordReset(ForgotPasswordRequest $request){
         $user=User::where('email','=',$request->email)->where('reset_token','=',$request->token)->first();
         $user->password=bcrypt($request->password);
         $user->reset_token=null;
         $user->save();
         return $user;
     }
}
