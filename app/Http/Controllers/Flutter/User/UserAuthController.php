<?php

namespace App\Http\Controllers\Flutter\User;
use App\User;
use Illuminate\Support\Str;
use App\Message\ResponseMessage;
use Tymon\JWTAuth\Facades\JWTAuth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FlutterUserLoginRequest;
use App\Http\Requests\FlutterUpdateUserResquest;
use App\Http\Requests\FlutterUserRegisterRequest;
use App\Models\Nurse;

class UserAuthController extends Controller
{
    public function register(FlutterUserRegisterRequest $request) {
        try {

            $data = array();
            $data['name'] = $request->name;
            $data['phone'] = $request->phone;
            // $data['password'] = Hash::make($request->password);
            $data['socId']='1';
            $data['notification_token']=$request->notification_token;

            User::query()->create($data);

            return parent::sendRespons(['result'=>[]],ResponseMessage::$registerSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(UserAuthController::class,25),500) ;
        }
    }

    public function isUser($phone){
        try{
        $user=User::query()->where('phone','=',$phone)->first();
        if(!$user)
        {
            return parent::sendRespons(['result'=>[
                'data'=>[ 'message' =>ResponseMessage::$isUserNotRegister]
            ]],"The User is not Register",200);
        }
        else{
            return  parent::sendError(null,ResponseMessage::$isUserRegister);
        }
    }catch(\Throwable $e){
        return parent::sendError($e->getMessage(),parent::getPostionError(UserAuthController::class,47),500);
        }
    }

    public function login(FlutterUserLoginRequest $request)
    {
    try {
        $guard='api';
        $credentials = request(['phone']);

        $token='';
        if($request['socId']=='UserType.user')
        {
            $isUser=$this->myCustomAuth($request->phone,$request->socId);
        if($isUser){
            $token=JWTAuth::fromUser($isUser);
            auth()->login($isUser);
        }
        else {
            return Controller::sendError(null,ResponseMessage::$loginErrorMessage);
        }
        }
        else if($request['socId']=='UserType.nurse'){
            $guard='nurse';
            $isUser=$this->myCustomAuth($request->phone,$request->socId);
            if($isUser){
                $token=JWTAuth::fromUser($isUser);
                auth($guard)->login($isUser);
            }
            else {
                return Controller::sendError(null,ResponseMessage::$loginErrorMessage);
            }
        }
        else if($request['socId']=='UserType.lab'){
            if($request->has('password'))
            {
                $credentials['password']=$request->password;
            }
            else
            {
                return Controller::sendError(null,ResponseMessage::$loginUndifinedUser);
            }
            $guard='lab';
            if (! $token = auth($guard)->attempt($credentials)) {
                return Controller::sendError(null,ResponseMessage::$loginErrorMessage);
            }
        }
        else
        {
            return Controller::sendError(null,ResponseMessage::$loginUndifinedUser);
        }
        $user=auth($guard)->user();
        if($request->has('token'))
        {
            $user->notification_token=$request->token;
            $user->save();
        }
        $user['token']=$token;
        $user['type']=$guard;
        return parent::sendRespons(['result'=>$user],ResponseMessage::$loginSuccessfullMessage,200);
    } catch (\Throwable $th) {
        return parent::sendError($th->getMessage(),parent::getPostionError(UserAuthController::class,94),500);
    }

    }

    public function getUser() {
    try{
        $user = auth('api')->user();
        return parent::sendRespons(['result'=>$user],ResponseMessage::$registerSuccessfullMessage,200);
    } catch (\Throwable $th) {
        return parent::sendError($th->getMessage(),parent::getPostionError(UserAuthController::class,98),500);
    }
    }

    public function updateUser(FlutterUpdateUserResquest $request){
        try {
            $user = auth('api')->user();
            $user->address=($request->address)?$request->address:$user->address;
            if(is_file($request['photo']))
            {
                $image=$request['photo'];
                $format = $image->getClientOriginalExtension();
                $fileName = time() . rand(1, 999999) . '.' . $format;
                $path = 'userImage/' . $fileName;
                $image->storeAs('userImage', $fileName);
                $photo=Str::afterLast($user->photo, '/storage/');
                if($photo!=null && Storage::exists($photo)){
                    Storage::delete($photo);
                }
                $path=Storage::disk('public')->url($path);
                $user->photo=$path;
            }
            $user->gendor=($request->gendor)?$request->gendor:$user->gendor;
            $user->birthDay=($request->birthDay)?$request->birthDay:$user->birthDay;
            $user->save();
            // User::query()->where('id','=',$user->id)->update((array)$user);
            return parent::sendRespons(['result'=>$user],ResponseMessage::$registerSuccessfullMessage,200);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(UserAuthController::class,114),500);
        }
    }

        public function logout()
        {
            auth()->logout();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$registerSuccessfullMessage,200);
        }

        function myCustomAuth($phone,$type){
            if($type=='UserType.user')
            $user= User::query()->where('phone','=',$phone)->get();
            else
            $user=Nurse::query()->where('phone','=',$phone)->get();
            if(count($user)!=1)
            {
                return false;
            }
            else
            {
                return $user[0];
            }
        }
}
