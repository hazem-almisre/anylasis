<?php

namespace App\Http\Controllers\Flutter\Order;

use App\Models\OrderApi;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlutterGetOrderByStatusResquest;
use App\Http\Requests\FlutterOrderChangeStatusResquest;

class OrderNurseController extends Controller
{
    public function getOrderByStatus(FlutterGetOrderByStatusResquest $request)
    {
        try{
        $nurseId = auth('nurse')->id();
        if($request->status == "finish"){
         $orders = OrderApi::query()->where('nurseId','=', $nurseId)->where('status','=' , $request->status)->with('contact')->with('lab')
         ->with('lines')->paginate(10);
         return parent::sendRespons(['result'=>$orders->items()],ResponseMessage::$registerNurseSuccessfullMessage);
        }
        else if($request->status == "prosessing"){
            if (!$request->has('date')) {
                return parent::sendError(null,"date must be exits");
            }
            else {
                $date=strtotime($request->date);
                $orders = OrderApi::query()->where('nurseId','=', $nurseId)->where('date','=',$date)->where('status','=' , $request->status)
                ->with('contact')->with('lab')->with('lines')->paginate(10);
                return parent::sendRespons(['result'=>$orders->items()],ResponseMessage::$registerNurseSuccessfullMessage);
            }
        }
        }
        catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(OrderNurseController::class,20),500) ;
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
