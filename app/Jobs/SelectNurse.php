<?php

namespace App\Jobs;

use App\Http\Controllers\Helper\NotifictionHelper;
use Exception;
use App\Models\Contact;
use App\Models\Nurse;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SelectNurse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $data;
    public function __construct($data)
    {
        $this->data=$data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $nurses=Nurse::selectNurseOrder($this->data['contact']['region'],$this->data['lab']['labId']);
        // print_r($nurses);
        foreach ($nurses as $value) {
            if($value->isActive){
                NotifictionHelper::send_notification_FCM($value->notification_token,'new Order',"recive Order",$value->nurseId,'order',$this->data);
            }
        }

    }
}

