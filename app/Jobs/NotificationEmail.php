<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use App\Notification;

class NotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $email_from;
    protected $email;
    protected $email_cc;
    protected $email_bcc;
    protected $subject_name;
    protected $campaign_name;
    public $timeout = 120;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        //
        $this->email_from   = $data->email_from;
        $this->email        = $data->email;
        $this->email_cc     = $data->email_cc;
        $this->email_bcc    = $data->email_bcc;
        $this->subject_name    = $data->subject_name;
        $this->campaign_name    = $data->campaign_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $data = [
            'email_from' => $this->email_from,
            'email' => $this->email,
            'email_cc' => $this->email_cc,
            'email_bcc' => $this->email_bcc,
            'subject_name' => $this->subject_name,
            'campaign_name' => $this->campaign_name
        ];

       Mail::send('email.sendNotificationEmail', array("campaign_name" => $data["campaign_name"]), function ($message) use ($data)
        {
            $message->from($data['email_from']);
            $message->to($data['email']);
            if(!empty($data['email_cc']))
            {
                 $message->cc($data['email_cc']);
            }
            if(!empty($data['email_bcc']))
            {
                $message->bcc($data['email_bcc']);
            }
            $message->subject($data['subject_name'].' - '.date("Ymd"));
        });
    }
}
