<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data = array();
    protected $sms = array();
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $sms)
    {
        $this->data = $data;
        $this->sms = $sms;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $sms = $this->sms;
        Mail::send('emails.send', $data, function ($m) use ($data) {
            $m->from('zaffron@cms.com', 'College Management System');
            $m->to($data['email'], $data['name'])->subject('Your Child\'s missing attendance!');
        });

        $ch = curl_init();
        $user="avlasgamer2427@gmail.com:#123Zalayan#";
        $receipientno=$sms['contact'];
        $senderID="TEST SMS";
        $msgtxt="This message is from CMS.Your child ".$sms['name']." hasn't attended class for a week. We request you to contact him and provide the reasons. Your call to the proctor will be really appreciated.";
        curl_setopt($ch,CURLOPT_URL,  "http://api.mVaayoo.com/mvaayooapi/MessageCompose");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "user=$user&senderID=$senderID&receipientno=$receipientno&msgtxt=$msgtxt");
        $buffer = curl_exec($ch);
        if(empty ($buffer))
        { echo " buffer is empty "; }
        else
        { echo $buffer; }
        curl_close($ch);
        return response()->json(['message' => 'Request completed']);
    }
}
