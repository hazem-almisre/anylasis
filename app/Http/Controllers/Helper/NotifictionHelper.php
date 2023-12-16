<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotifictionHelper extends Controller
{
    static  function send_notification_FCM($notification_token, $title, $message, $id,$type,$data) {


        $SERVER_API_KEY = "AAAAumSSWB0:APA91bGeUOfF76eM_aTMv8ju8B320SfHwrf1E5EHoQmHNV7neeoehMZZzAn6TrC6MQ9mn19AanUMjQfE9ukCIe-6xVopfRNy1n1VZ2Up2Bnthm-D2ZAzCL-hFSJR4llx7rSN-F77Jle3";//env('FCM_KEY');


        $data = [

            "registration_ids" => [
                $notification_token
            ],

            "data"=> [

                "body"=> $data,

                "title"=>  $title ,

                "type"=>  $type ,

                "id"=>  $id ,

                "message"=>  $message ,
            ],

            "notification" => [

                "type" => $type,

                "id" => $id ,

                "message" => $message,

                "icon" => "new",

                "title" => $title,

                "body" => $message,

                "sound"=> "default" // required for sound on ios

            ],

        ];

        $dataString = json_encode($data);

        $headers = [

            'Authorization: key=' . $SERVER_API_KEY,

            'Content-Type: application/json',

        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        curl_setopt($ch, CURLOPT_POST, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $rest = curl_exec($ch);

        if ($rest === false) {
            // throw new Exception('Curl error: ' . curl_error($crl));
            //print_r('Curl error: ' . curl_error($crl));
            $result_noti = 0;
        } else {

            $result_noti = 1;
        }

        //curl_close($crl);
        //print_r($result_noti);die;
        return $result_noti;
    }
}


// $post_data = '{
//     "to" : "' . $notification_token . '",
//     "data" : {
//       "body" : "'.$data.'",
//       "title" : "' . $title . '",
//       "type" : "' . $type . '",
//       "id" : "' . $id . '",
//       "message" : "' . $message . '",
//     },
//     "notification" : {
//          "body" : "' . $message . '",
//          "title" : "' . $title . '",
//           "type" : "' . $type . '",
//          "id" : "' . $id . '",
//          "message" : "' . $message . '",
//         "icon" : "new",
//         "sound" : "default"
//         },

//   }';
