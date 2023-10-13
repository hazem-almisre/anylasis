<?php

namespace App\Http\Controllers\Flutter\Order;

use App\Models\OrderApi;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlutterAddOrderResquest;
use App\Http\Requests\FlutterGetOrderByStatusResquest;
use App\Http\Requests\FlutterOrderChangeStatusResquest;
use App\Jobs\SelectNurse;
use App\Models\Line;

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
                'isFrequency'=>$isFrequency,
                'instructios'=>$request->contactId
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
            // dispatch(new SelectNurse($request->contactId,$request->labId,$order));
            return parent::sendRespons(['result'=>$order],ResponseMessage::$registerNurseSuccessfullMessage);
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
         $orders = OrderApi::query()->where('userId','=', $userId)->with('lines',function($q) use($status){
            $q->where('status','LIKE' , "%$status%")->get();
         })->with('nurse')->with('lab')->paginate(10);
         return parent::sendRespons(['result'=>$orders],ResponseMessage::$registerNurseSuccessfullMessage);
        }
        catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(OrderUserController::class,70),500) ;
        }
    }

    public function changeOrderStatus(FlutterOrderChangeStatusResquest $request)
    {
        try{
         $order = Line::query()->findOrFail($request->lineId);
         $order->status = ($request->status)?$order->status:$request->status;
         $order->save();
         return parent::sendRespons(['result'=>[]],ResponseMessage::$registerNurseSuccessfullMessage);
        }
        catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(OrderUserController::class,83),500) ;
        }
    }


}
