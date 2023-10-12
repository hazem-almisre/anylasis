<?php

namespace App\Http\Controllers\Web\Analysis;

use App\Models\Analysis;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebAddAnalysisRequest;

class AnalysisLabController extends Controller
{
    public function index()
    {
        try {
            $analysis= Analysis::all();
            return parent::sendRespons(['result'=>$analysis],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(AnalysisLabController::class,18),500) ;
        }
    }

    public function store(WebAddAnalysisRequest $request)
    {
        try {
            if($request->secondPrice)
            {
                $request['firstPrice']=$request['price'];
                $request['price']=$request['secondPrice'];
            }
            else
            {
                $request['firstPrice']=$request['price'];
            }
            $analysis=Analysis::query()->create([
            'labId'=> auth('lab')->id(),
            'lable'=>$request['lable'],
            'price'=>$request['price'],
            'firstPrice'=>$request['firstPrice'],
            'secondPrice'=>$request['secondPrice'],
            'description'=>$request['description']
            ]);
            return parent::sendRespons(['result'=>$analysis],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(AnalysisLabController::class,39),500) ;
        }
    }


    public function show($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($analysisId)
    {
        try {
            $analysis = Analysis::query()->where('analysisId','=',$analysisId)->delete();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$nurseDeleteSuccessfull);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,57),500) ;
        }

    }
}
