<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class VerifyLeadsEveryCampaignEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request;
    protected $email_relate;
    protected $email_from;
    protected $email_account_manager;
    protected $name_account_manager;
    protected $email_bcc;
    protected $subject_name;
    public $timeout = 120;
    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $email_relate, $email_from, $email_account_manager, $name_account_manager, $email_bcc, $subject_name)
    {
        //
        $this->request        = $request;
        $this->email_relate   = $email_relate;
        $this->email_from     = $email_from;
        $this->email_account_manager   = $email_account_manager;
        $this->name_account_manager   = $name_account_manager;
        $this->email_bcc      = $email_bcc;
        $this->subject_name   = $subject_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request            = $this->request;
        $email_relate       = $this->email_relate;
        $email_from         = $this->email_from;
        $email_account_manager = $this->email_account_manager;
        $name_account_manager = $this->name_account_manager;
        $email_bcc          = $this->email_bcc;
        $subject_name       = $this->subject_name;

        $data = [
            'email_relate' => $email_relate,
            'email_from' => $email_from,
            'email_account_manager' => $email_account_manager,
            'name_account_manager' => $name_account_manager,
            'email_bcc' => $email_bcc,
            'subject_name' => $subject_name
        ];

        Mail::send('email.sendVerifyLeadsEveryCampaignEmail', array(
            "data" => $request,
            "email_relate" => $email_relate,
            "email_from" => $email_from,
            "email_account_manager" => $email_account_manager,
            "name_account_manager" => $name_account_manager,
            "email_bcc" => $email_bcc,
            "subject_name" => $subject_name
        ), function ($message) use ($data)
        {
            $message->from($data['email_from']);
            $message->to($data['email_account_manager']);
            if(!empty($data['email_relate']))
            {
                 $message->cc($data['email_relate']);
            }
            if(!empty($data['email_bcc']))
            {
                $message->bcc($data['email_bcc']);
            }
            $message->subject($data["subject_name"].' - '.date("Y-m-d"));
        });
    }
}
