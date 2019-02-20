<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class ResetPasswordEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $email_from;
    public $name;
    public $email;
    public $subject_name;
    public $url;
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
        $this->email_from   = $data->get('email_from');
        $this->name         = $data->get('name');
        $this->email        = $data->get('email');
        $this->subject_name = $data->get('subject_name');
        $this->url          = $data->get('url');
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
            'name' => $this->name,
            'email' => $this->email,
            'subject_name' => $this->subject_name,
            'url' => $this->url
        ];

        Mail::send('email.sendResetPasswordEmail', array(
                "name" => $data["name"],
                "subject_name" => $data["subject_name"],
                "url" => $data["url"]
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
            $message->subject($data['subject_name']);
        });
    }
}
