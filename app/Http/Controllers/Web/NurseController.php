<?php

namespace App\Http\Controllers\Web;

use App\Models\Nurse;
use App\Models\DoctorAreas;
use App\Models\LabLocation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\WebAddNursRequest;
use App\Models\NurseLab;

class NurseController extends Controller
{
    public function addNurse(WebAddNursRequest $request) {
        try {
            DB::beginTransaction();
            if($request['photo'])
            {
                $image=$request['photo'];
                $format = $image->getClientOriginalExtension();
                $fileName = time() . rand(1, 999999) . '.' . $format;
                $path = 'nurseImage/' . $fileName;
                $image->storeAs('nurseImage', $fileName);
            }
            $active=false;
            if($request->has('isActive'))
            {
                if($request->isActive=="true")
                {
                    $active=true;
                }
            }
            $nurse=Nurse::query()->create([
                'photo'=>$path,
                'name'=>$request->name,
                'address'=>$request->address,
                'phone'=>$request->phone,
                'ratio'=>$request->ratio,
                'password'=>Hash::make($request->password),
                'isActive'=>$active,
            ]);

            $array=[];
            $n=Str::length( $request['labLocationIds']);
            for ($i=0;$i<$n;$i++) {
                if( $request['labLocationIds'][$i]!=',')
                DoctorAreas::query()->create([
                    'labLocationId'=>(int) $request['labLocationIds'][$i],
                    'nurseId'=>$nurse->nurseId,
                ]);
            }

            $n=Str::length( $request['labs']);
            for ($i=0;$i<$n;$i++) {
                if( $request['labs'][$i]!=',')
                NurseLab::query()->create([
                    'labId'=>(int) $request['labs'][$i],
                    'nurseId'=>$nurse->nurseId,
                ]);
            }
            DB::commit();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            DB::rollBack();
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,62),500) ;
        }
    }

    public function index()
    {
        try {
            $nurses= Nurse::all();
            return parent::sendRespons(['result'=>$nurses],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,72),500) ;
        }

    }

    public function destroy($nurseId)
    {
        try {
            $nurse = Nurse::query()->where('nurseId','=',$nurseId)->first();
            $photo = $nurse->photo;
            if(Storage::exists($photo))
            Storage::delete($photo);
            $nurse->delete();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$nurseDeleteSuccessfull);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,70),500) ;
        }

    }

    public function changeActivie($nurseId) {
        try {
            $nurse = Nurse::query()->where('nurseId','=',$nurseId)->first();
            $nurse->isActive = !($nurse->isActive);
            $nurse->save();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$nurseDeleteSuccessfull);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,82),500) ;
        }
    }

    public function getRegions() {
        try {
            $labLocations= LabLocation::all();
            return parent::sendRespons(['result'=>$labLocations],ResponseMessage::$getLabLocations);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(AdminLabController::class,91),500) ;
        }
    }


}
