<?php

namespace App\Http\Controllers\Flutter\Order;

use App\Models\Line;
use App\Models\Nurse;
use App\Models\Contact;
use App\Models\OrderApi;
use App\Jobs\SelectNurse;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlutterAddOrderResquest;
use App\Http\Controllers\Helper\NotifictionHelper;
use App\Http\Requests\FlutterGetOrderByStatusResquest;
use App\Http\Requests\FlutterOrderChangeStatusResquest;

class OrderUserController extends Controller
{
    public function store(FlutterAddOrderResquest $request)
    {
        try {
            DB::beginTransaction();
            $userId = auth()->id();
            $isFrequency=false;
            $numberCount=count($request['lines']);
            if ($numberCount>1) {
                $isFrequency=true;
            }
            $order=OrderApi::query()->create([
                'contactId'=>$request->contactId,
                'totalPrice'=>$request->totalPrice,
                'date'=>$request->date,
                'labId'=>$request->labId,
                'userId'=>$userId,
                'isFrequency'=>(bool)$isFrequency,
                'instructios'=>$request->contactId,
                'status'=>"prosessing",
            ]);

            $lines=[];
            for ($i=0; $i < $numberCount; $i++) {
                $lines[]=Line::query()->create([
                    'dateStart'=>$request['lines'][$i]['dateStart'],
                    'analysis'=>$request['lines'][$i]['analysis'],
                    'price'=>$request['lines'][$i]['price'],
                    'status'=>"prosessing",
                    'orderId'=>$order->orderId
                ]);
            }
            $order['lines']=$lines;
            DB::commit();
             SelectNurse::dispatch($request->contactId,$request->labId,$order);
            return parent::sendRespons(['result'=>$order->orderId],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            DB::rollBack();
            return parent::sendError($th->getMessage(),parent::getPostionError(OrderUserController::class,52),500) ;
        }
    }


    //upcomming
    public function getOrderByStatus(FlutterGetOrderByStatusResquest $request)
    {
        try{
        $userId = auth()->id();
        $status=$request->status;
        //$id = Auth::id();
         $orders = OrderApi::query()->where('userId','=', $userId)->where('status','=', "$status")
         ->with('lines')->with('nurse')->with('lab')->paginate(10);
         return parent::sendRespons(['result'=>$orders->items()],ResponseMessage::$registerNurseSuccessfullMessage);
        }
        catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(OrderUserController::class,70),500) ;
        }
    }

    public function changeOrderStatus(FlutterOrderChangeStatusResquest $request)
    {
        try{
         $order = OrderApi::query()->findOrFail($request->orderId);
         $lines = $order->lines;
         $orderFinish = true;
         foreach ($lines as $value)
         {
            if($value->lineId == $request->lineId){
                $value->status=$request->status;
                $value->save();
            }
            if($value->status != "finish")
            {
                $orderFinish = false;
            }
         }
         if($orderFinish){
            $order->status = 'finish';
            $order->save();
         }
         return parent::sendRespons(['result'=>[]],ResponseMessage::$registerNurseSuccessfullMessage);
        }
        catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(OrderUserController::class,83),500) ;
        }
    }


}
