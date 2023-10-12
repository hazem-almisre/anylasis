<?php

use App\User;
use App\Http\Controllers\Helper\NotifictionHelper;
use App\Http\Controllers\Flutter\Lab\UserLabController;
use App\Http\Controllers\Web\Lab\AdminRegionController;
use App\Http\Controllers\Flutter\User\UserAuthController;
use App\Http\Controllers\Flutter\Order\OrderUserController;
use App\Http\Controllers\Flutter\User\RatingUserController;
use App\Http\Controllers\Flutter\User\ContactUserController;
use App\Http\Controllers\Web\Analysis\AnalysisLabController;
use App\Models\Nurse;
use Illuminate\Support\Facades\Route;  //--Eita dile ar "route" er niche error er red-wave ta r show kore na.

// use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//===================//=================//=================//==================//=================//=========



//---------------------For_JWT-------------------------

Route::group(['prefix'=>'mobile'],function () {
    Route::post('register', [UserAuthController::class,'register']);

    Route::get('/isUser/{phone}',[UserAuthController::class,'isUser']);

    Route::post('login',[UserAuthController::class,'login']);
});


Route::group(['prefix'=>'labs'],function () {
    Route::get('/getByRegion/{region}',[UserLabController::class,'getLabsByRegion']);

    Route::get('getAll',[UserLabController::class,'getLabs']);

    Route::get('get/region', [AdminRegionController::class,'getRegions']);

    Route::get('searchByName/{labName}',[UserLabController::class,'searchByName']);

    Route::get('getLabsWithDistinct',[UserLabController::class,'getLabsWithDistinct']);

    Route::get('get/analyses/{labId}', [UserLabController::class,'getLabWithAnalyses']);

});

Route::group(['prefix'=>'contact' , 'middleware'=>'auth:api'],function () {
    Route::get('getAll',[ContactUserController::class,'index']);

    Route::post('add',[ContactUserController::class,'store']);

    Route::delete('delete/{contactId}', [ContactUserController::class,'destroy']);

});

Route::post('rate/add',[RatingUserController::class,'store'])->middleware('auth:api');

Route::group(['prefix'=>'user' , 'middleware'=>'auth:api'],function () {
    Route::get('get',[UserAuthController::class,'getUser']);

    Route::post('update',[UserAuthController::class,'updateUser']);
});

Route::group(['prefix'=>'order' , 'middleware'=>'auth:api'],function () {
    Route::post('add',[OrderUserController::class,'store']);

    Route::get('getByStatus',[OrderUserController::class,'getOrderByStatus']);

    Route::post('changeStatus',[OrderUserController::class,'changeOrderStatus']); // add it in postman to test

});


Route::get('not/{userId}',function($id){
    $user=User::query()->find($id);
    NotifictionHelper::send_notification_FCM($user->notification_token,"Hi Bassam","i am Hazem Almasri",$user->id,"Order",$user);
    return $user;
});
