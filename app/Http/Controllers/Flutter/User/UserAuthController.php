<?php

namespace App\Http\Controllers\Flutter\User;
use App\User;
use App\Models\Analysis;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlutterUpdateUserResquest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\isEmpty;
use App\Http\Requests\FlutterUserLoginRequest;
use App\Http\Requests\FlutterUserRegisterRequest;
use App\Models\Lab;
use Illuminate\Support\Facades\Storage;

class UserAuthController extends Controller
{
    public function register(FlutterUserRegisterRequest $request) {
        try {

            $data = array();
            $data['name'] = $request->name;
            $data['phone'] = $request->phone;
            $data['password'] = Hash::make($request->password);
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
        $credentials = request(['phone', 'password']);

        $token='';
        if($request['socId']=='UserType.user')
        {
        if (! $token = auth($guard)->attempt($credentials)) {
            return Controller::sendError(null,ResponseMessage::$loginErrorMessage);
        }
        }
        else if($request['socId']=='UserType.nurse'){
            $guard='nurse';
            if (! $token = auth($guard)->attempt($credentials)) {
                return Controller::sendError(null,ResponseMessage::$loginErrorMessage);
            }
        }
        else if($request['socId']=='UserType.lab'){
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
                if(Storage::exists($user->photo)){
                    Storage::delete($user->photo);
                }
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
}
