<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBecomeNurseRequest;
use App\Models\BecomeNurse;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;

class BecomNurseController extends Controller
{
    /**
     * Display a listing of the employe order.
     */
    public function index()
    {
        try{
             $BecomeNurseList = BecomeNurse::query()->paginate(10);
             return parent::sendRespons(['result'=>$BecomeNurseList->items()],ResponseMessage::$registerNurseSuccessfullMessage);
            }
            catch (\Throwable $th) {
                return parent::sendError($th->getMessage(),parent::getPostionError(BecomNurseController::class,22),500) ;
            }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddBecomeNurseRequest $request)
    {
        try{
            $userId=auth()->id();
            $becomeNurseOrder = BecomeNurse::query()->where('userId','=',$userId)->get();
            if(count($becomeNurseOrder)>=1)
            {
                return Controller::sendError(null,"you are already have send befor");
            }
            $request['userId']=$userId;
            $becomeNurseOrder= BecomeNurse::query()->create($request->all());
            return parent::sendRespons(['result'=>$becomeNurseOrder->becomeNurseId],ResponseMessage::$registerNurseSuccessfullMessage);
        }
            catch (\Throwable $th) {
                return parent::sendError($th->getMessage(),parent::getPostionError(OrderNurseController::class,41),500) ;
            }
    }

    public function destroy(string $id)
    {
        //
    }
}
