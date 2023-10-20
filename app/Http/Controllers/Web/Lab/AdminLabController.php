<?php

namespace App\Http\Controllers\Web\Lab;

use App\Models\Lab;
use App\Models\LabLocation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\WebAddLabRequest;
use Illuminate\Support\Facades\Storage;

class AdminLabController extends Controller
{
    public function getRegions(){
        try {
            $labLocations= LabLocation::all();
            return parent::sendRespons(['result'=>$labLocations],ResponseMessage::$getLabLocations);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(AdminLabController::class,19),500) ;
        }

    }

    public function addLab(WebAddLabRequest $request) {
        try {
            if($request['photo'])
            {
                $image=$request['photo'];
                $format = $image->getClientOriginalExtension();
                $fileName = time() . rand(1, 999) . '.' . $format;
                $path = 'labImage/' . $fileName;
                $image->storeAs('labImage', $fileName);
                $path=Storage::disk('public')->url($path);
            }
            $active=false;
            if($request->has('isActive'))
            {
                if($request->isActive=="true")
                {
                    $active=true;
                }
            }
            $lab=Lab::query()->create([
                'photo'=>$path,
                'name'=>$request->name,
                'ownerName'=>$request->ownerName,
                'address'=>$request->address,
                'phone'=>$request->phone,
                'phoneEnter'=>$request->phoneEnter,
                'region'=>$request->region,
                'labLocationId'=>$request->labLocationId,
                'password'=>Hash::make($request->password),
                'isActive'=>$active,
            ]);
            return parent::sendRespons(['result'=>[]],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(AdminLabController::class,57),500) ;
        }
    }
    public function index() {
        try {
            $labs= Lab::all();
            return parent::sendRespons(['result'=>$labs],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(AdminLabController::class,65),500) ;
        }
    }

    public function changeActivie($labId) {
        try {
            $lab = Lab::query()->where('labId','=',$labId)->first();
            $lab->isActive = !($lab->isActive);
            $lab->save();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$nurseDeleteSuccessfull);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(AdminLabController::class,76),500) ;
        }
    }

    public function destroy($labId){
        try {
            $lab = Lab::query()->where('labId','=',$labId)->first();
            $photo = $lab->photo;
            $photo=Str::afterLast($photo, '/storage/');
            if(Storage::exists($photo))
            Storage::delete($photo);
            $lab->delete();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$nurseDeleteSuccessfull);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,90),500) ;
        }

    }
}
