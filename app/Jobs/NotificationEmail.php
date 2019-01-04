<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class NotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $name;
    public $email_from;
    public $email;
    public $email_cc;
    public $email_bcc;
    public $subject_name;
    public $campaign_name;
    public $channel_name;
    public $issue;
    public $link_campaign;
    public $link_channel;
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
        $this->name   = $data->get('name');
        $this->email_from   = $data->get('email_from');
        $this->email        = $data->get('email');
        $this->email_cc     = $data->get('email_cc');
        $this->email_bcc    = $data->get('email_bcc');
        $this->subject_name    = $data->get('subject_name');
        $this->campaign_name    = $data->get('campaign_name');
        $this->channel_name    = $data->get('channel_name');
        $this->issue    = $data->get('issue');
        $this->link_campaign    = $data->get('link_campaign');
        $this->link_channel    = $data->get('link_channel');
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
            'name' => $this->name,
            'email_from' => $this->email_from,
            'email' => $this->email,
            'email_cc' => $this->email_cc,
            'email_bcc' => $this->email_bcc,
            'subject_name' => $this->subject_name,
            'campaign_name' => $this->campaign_name,
            'channel_name' => $this->channel_name,
            'issue' => $this->issue,
            'link_campaign' => $this->link_campaign,
            'link_channel' => $this->link_channel
        ];

        Mail::send('email.sendNotificationEmail', array(
                "name" => $data["name"],
                "subject_name" => $data["subject_name"],
                "campaign_name" => $data["campaign_name"],
                "channel_name" => $data["channel_name"],
                "issue" => $data["issue"],
                "link_campaign" => $data["link_campaign"],
                "link_channel" => $data["link_channel"]
            ), function ($message) use ($data)
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
            $message->subject($data['subject_name'].' - '.date("Y-m-d"));
        });
    }
}
