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
    private $contactId;
    private $labId;
    private $orderWithLines;
    public function __construct($contactId,$labId,$orderWithLines)
    {
        $this->contactId=$contactId;
        $this->labId=$labId;
        $this->orderWithLines=$orderWithLines;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $region = Contact::query()->select('region')->findOrFail($this->contactId);
        $nurses=Nurse::selectNurseOrder($region->region,$this->labId);
        foreach ($nurses as $value) {
            if($value->isActive){
                NotifictionHelper::send_notification_FCM($value->notification_token,'new Order',"recive Order",$value->nurseId,'order',$this->orderWithLines);
            }
        }

    }
}

