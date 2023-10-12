<?php

namespace App\Http\Controllers\Flutter\User;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Message\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\FlutterAddContactResquest;

class ContactUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $userId = auth()->id();
            $contacts= Contact::query()->where('id','=',$userId)->get();
            return parent::sendRespons(['result'=>$contacts],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(ContactUserController::class,25),500) ;
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FlutterAddContactResquest $request)
    {
        try {
            $userId = auth()->id();
            $request['id'] = $userId;
            $contact=Contact::query()->create($request->all());
            return parent::sendRespons(['result'=>$contact->contactId],ResponseMessage::$registerNurseSuccessfullMessage);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(ContactUserController::class,45),500) ;
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($contactId)
    {
        try {
            $contact = Contact::query()->where('contactId','=',$contactId)->delete();
            return parent::sendRespons(['result'=>['message'=>"contact is deleted"]],ResponseMessage::$nurseDeleteSuccessfull);
        } catch (\Throwable $th) {
            return parent::sendError($th->getMessage(),parent::getPostionError(ContactUserController::class,62),500) ;
        }
    }
}
