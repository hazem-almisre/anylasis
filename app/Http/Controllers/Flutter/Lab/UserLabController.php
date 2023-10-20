<?php

namespace App\Http\Controllers\Flutter\Lab;

use App\Models\Lab;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Models\LabLocation;

class UserLabController extends Controller
{

    public function getLabs()  {
        try {
            $labs= Lab::query()->paginate(10);
            return parent::sendRespons(['result'=>$labs],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(UserLabController::class,15),500) ;
        }
    }

    public function getLabsWithDistinct()  {
        try {
            $labs['distinct']= Lab::query()->where('distinct','=',true);
            $labs['notDistinct']= Lab::query()->where('distinct','<>',true)->limit(5)->get();
            return parent::sendRespons(['result'=>$labs],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(UserLabController::class,29),500) ;
        }
    }


    public function getLabsByRegion($region)  {
        try {
            $labs=LabLocation::query()->where('region','=',$region)->with('labs')->get();
            return parent::sendRespons(['result'=>$labs],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(UserLabController::class,39),500) ;
        }
    }

    public function searchByName($labName){
        try {
            $result=array();
            $result['likeName']=[];
            $result['sameName']=[];
            $labs=Lab::query()->where('name','like',"%$labName%")->get();
            foreach ($labs as $value) {
                if($value['name'] == $labName){
                    $result['sameName'][]=$value;
                }
                else {
                    $result['likeName'][]=$value;
                }
            }
            return parent::sendRespons(['result'=>$result],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(UserLabController::class,59),500) ;
        }
    }

    public function getLabWithAnalyses($labId) {
        try {
            $labWithAnalyses= Lab::query()->where('labId','=',$labId)->with('analyses')->first();
            return parent::sendRespons(['result'=>$labWithAnalyses],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(UserLabController::class,68),500) ;
        }
    }
}
