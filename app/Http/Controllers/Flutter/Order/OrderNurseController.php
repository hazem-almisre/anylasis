<?php

namespace App\Http\Controllers\Flutter\Order;

use App\Models\OrderApi;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlutterGetOrderByStatusResquest;

class OrderNurseController extends Controller
{
    public function getOrderByStatus(FlutterGetOrderByStatusResquest $request)
    {
        try{
        $nurseId = auth('nurse')->id();
         $orders = OrderApi::query()->where('nurseId','=', $nurseId)->where('status','=' , $request->status)->with('contact')->with('lab')->paginate(10);
         return parent::sendRespons(['result'=>$orders],ResponseMessage::$registerNurseSuccessfullMessage);
        }
        catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(OrderNurseController::class,20),500) ;
        }
    }
}
