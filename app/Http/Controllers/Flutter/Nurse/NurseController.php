<?php

namespace App\Http\Controllers\Flutter\Nurse;

use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlutterNurseAcceptOrder;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FlutterUpdateNurseResquest;
use Illuminate\Support\Facades\DB;

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
                    $path=Storage::disk('public')->url($path);
                    $user->photo=$path;
                }
                $user->save();
                // User::query()->where('id','=',$user->id)->update((array)$user);
                return parent::sendRespons(['result'=>$user],ResponseMessage::$registerSuccessfullMessage,200);
            } catch (\Throwable $th) {
                return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,45),500);
            }
        }

    public function acceptedOrder(FlutterNurseAcceptOrder $request) {
        try {
            $order=DB::table('order_apis')->select('nurseId')->where('orderId','=',$request->orderId)->lockForUpdate()->first();
            if($order['nurseId'] !=null)
            {
                $order['nurseId']=auth('nurse')->id();
                $order->unlock();
                return parent::sendRespons(['result'=>[]],ResponseMessage::$acceptedNurse,200);
            }
            $order->unlock();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$notAcceptedNurse,200);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,60),500);
        }
    }
}
