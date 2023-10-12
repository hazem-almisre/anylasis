<?php

namespace App\Http\Controllers\Web\Lab;

use App\Models\LabLocation;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\WebAddRegionRequest;

class AdminRegionController extends Controller
{
    public function addRegion(WebAddRegionRequest $request) {
        try {
            $region=LabLocation::query()->create($request->all());
            return parent::sendRespons(['result'=>[$region]],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(AdminRegionController::class,18),500) ;
        }
    }

    public function getRegions() {
        try {
            $labLocations= LabLocation::all();
            return parent::sendRespons(['result'=>$labLocations],ResponseMessage::$getLabLocations);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(AdminLabController::class,27),500) ;
        }
    }
}
