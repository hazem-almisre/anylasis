<?php

namespace App\Http\Controllers\Web\Lab;

use App\Models\LabLocation;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\WebUpdateLabeResquest;

class LabProfileController extends Controller
{
    public function getLab() {
        try{
            $user = auth('lab')->user();
            $user->makeVisible(['phoneEnter']);
            return parent::sendRespons(['result'=>$user],ResponseMessage::$registerSuccessfullMessage,200);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(LabProfileController::class,98),500);
        }
        }

        public function updateLab(WebUpdateLabeResquest $request){
            try {
                $user = auth('lab')->user();
                $user->address=($request->address)?$request->address:$user->address;
                if(is_file($request['photo']))
                {
                    $image=$request['photo'];
                    $format = $image->getClientOriginalExtension();
                    $fileName = time() . rand(1, 999999) . '.' . $format;
                    $path = 'labImage/' . $fileName;
                    $image->storeAs('labImage', $fileName);
                    if(Storage::exists($user->photo)){
                        Storage::delete($user->photo);
                    }
                    $path=Storage::disk('public')->url($path);
                    $user->photo=$path;
                }
                $user->phoneEnter=($request->phoneEnter)?$request->phoneEnter:$user->phoneEnter;
                $user->ownerName=($request->ownerName)?$request->ownerName:$user->ownerName;
                $user->phone=($request->phone)?$request->phone:$user->phone;
                $user->region=($request->region)?$request->region:$user->region;
                // $user->description=($request->description)?$request->description:$user->description;
                $user->labLocationId=($request->labLocationId)?$request->labLocationId:$user->labLocationId;
                $user->save();
                // User::query()->where('id','=',$user->id)->update((array)$user);
                return parent::sendRespons(['result'=>$user],ResponseMessage::$registerSuccessfullMessage,200);
            } catch (\Throwable $th) {
                return parent::sendError($th->getMessage(),parent::getPostionError(LabProfileController::class,45),500);
            }
        }

        public function getRegions(){
            try {
                $labLocations= LabLocation::all();
                return parent::sendRespons(['result'=>$labLocations],ResponseMessage::$getLabLocations);
            } catch (\Throwable $th) {
                return parent::sendError($th->getMessage(),parent::getPostionError(LabProfileController::class,59),500) ;
            }

        }
}
