<?php

namespace App\Http\Controllers\Web\Offer;

use App\Models\Offer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\AnalysisOffers;
use App\Message\ResponseMessage;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\WebAddOfferRequest;

class OfferController extends Controller
{

    public function index()
    {
        try{
        $date=date('Y-m-d');
        $offers= Offer::query()->where('dateEnd','>=',$date)->with('analysis',function($q){
           $q->select( "lable","price","description","labId");
        })->orderBy('dateEnd')->get();
        return parent::sendRespons(['result'=>$offers],ResponseMessage::$getLabLocations);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(OfferController::class,19),500) ;
        }
    }

    public function store(WebAddOfferRequest $request)
    {
    try{
            DB::beginTransaction();
            // photo
            $image=$request['photo'];
            $format = $image->getClientOriginalExtension();
            $fileName = time() . rand(1, 999999) . '.' . $format;
            $path = 'offerImage/' . $fileName;
            $image->storeAs('offerImage', $fileName);

            $offer=Offer::query()->create([
                'photo'=>$path,
                'priceBeforOffer'=>$request->priceBeforOffer,
                'priceAfterOffer'=>$request->priceAfterOffer,
                'dateEnd'=>$request->dateEnd,
                'analysisCount'=>$request->analysisCount,
            ]);

            $array=[];
            $n=Str::length( $request['analysisIds']);
            for ($i=0;$i<$n;$i++) {
                if( $request['analysisIds'][$i]!=',')
                AnalysisOffers::query()->create([
                    'offerId'=> $offer->offerId,
                    'analysisId' => $request['analysisIds'][$i],
                ]);
            }
            DB::commit();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            DB::rollBack();
            return parent::sendError($th->getMessage(),parent::getPostionError(OfferController::class,55),500) ;
        }
    }

    public function show($offerId)
    {
        try {
            $offer=Offer::query()->where('offerId','=',$offerId)->with('analysis')->first();
            return parent::sendRespons(['result'=>$offer],ResponseMessage::$registerSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(OfferController::class,65),500);
        }
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($offerId)
    {
        try {
            $offer = Offer::query()->where('offerId','=',$offerId)->first();
            $photo = $offer->photo;
            if(Storage::exists($photo))
            Storage::delete($photo);
            $offer->delete();
            return parent::sendRespons(['result'=>[]],ResponseMessage::$nurseDeleteSuccessfull);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(NurseController::class,85),500) ;
        }
    }
}
