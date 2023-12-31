<?php

namespace App\Http\Controllers\Flutter\Nurse;

use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlutterNurseAcceptOrder;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\FlutterUpdateNurseResquest;
use App\Models\Nurse;
use App\Models\OrderApi;
use Illuminate\Support\Facades\DB;

class NurseController extends Controller
{
    public function getNurse() {
        try{
            $userId = auth('nurse')->id();
            $user=Nurse::query()->findOrFail($userId)->with('labsLocation')->get();
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
                    $photo=Str::afterLast($user->photo, '/storage/');
                    if($photo!=null && Storage::exists($photo)){
                        Storage::delete($photo);
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
            $order=OrderApi::where('orderId','=',$request->orderId)->first();
            if($order !=null && $order->nurseId ==null)
            {
                $order->lockForUpdate();
                $order->nurseId=auth('nurse')->id();
                $order->save();
                $order->unlock;
                return parent::sendRespons(['result'=>$order->orderId],ResponseMessage::$acceptedNurse,200);
            }
            else{
                $order->unlock;
            return parent::sendRespons(['result'=>$order->orderId],ResponseMessage::$notAcceptedNurse,200);
            }
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,60),500);
        }
    }
}
