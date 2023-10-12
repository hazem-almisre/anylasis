<?php

namespace App\Http\Controllers\Flutter\User;

use App\Models\Rating;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlutterAddRatingResquest;
use App\Models\OrderApi;

class RatingUserController extends Controller
{
    public function store(FlutterAddRatingResquest $request) {
        try {
            $userId = auth()->id();
            $request['userId'] = $userId;
            $order=OrderApi::query()->findOrFail($request->orderId);
            if($order->status == "finish")
            {
            $rating=Rating::query()->create($request->all());
            return parent::sendRespons(['result'=>$rating],ResponseMessage::$registerNurseSuccessfullMessage);
            }
            else{
                return parent::sendRespons(['result'=>[]],"order is not finish can not rate it");
            }
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(RatingUserController::class,28),500) ;
        }
    }
}
