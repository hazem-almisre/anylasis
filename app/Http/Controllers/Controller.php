<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    static public function sendRespons ( $result , $messages, $code = 200)
    {
    $respons =
    [
        'statusCode' => $code ,
        'message' => $messages,
        'data' =>  $result ,
    ];

    return response()->json($respons , $code);
    }

    static public function sendError ( $errors = [] ,$message , $code = 404)
    {

        $respons =
        [
            'statusCode' => $code ,
            'timestamp'=>now(),
            'data'  => $errors ,
            'message' => $message,
        ];

        return response()->json($respons,$code);
    }

    static function getPostionError(string $path,int $line){
        return "try agien please error in {$path} line {$line}";
    }
}
