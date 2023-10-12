<?php

namespace App\Http\Controllers\Flutter\Nurse;

use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FlutterUpdateNurseResquest;

class NurseController extends Controller
{
    public function getNurse() {
        try{
            $user = auth('nurse')->user();
            return parent::sendRespons(['result'=>$user],ResponseMessage::$registerSuccessfullMessage,200);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,98),500);
        }
        }
    
        public function updateNurse(FlutterUpdateNurseResquest $request){
            try {
                $user = auth('nurse')->user();
                $user->address=($request->address)?$request->address:$user->address;
                if($request['photo'])
                {
                    $image=$request['photo'];
                    $format = $image->getClientOriginalExtension();
                    $fileName = time() . rand(1, 999999) . '.' . $format;
                    $path = 'nurseImage/' . $fileName;
                    $image->storeAs('nurseImage', $fileName);
                    if(Storage::exists($user->photo)){
                        Storage::delete($user->photo);
                    }
                    $user->photo=$path;
                }
                $user->save();
                // User::query()->where('id','=',$user->id)->update((array)$user);
                return parent::sendRespons(['result'=>$user],ResponseMessage::$registerSuccessfullMessage,200);
            } catch (\Throwable $th) {
                return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,45),500);
            }
        }
}
