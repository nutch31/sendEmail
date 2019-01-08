<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class SummarizeNotificationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $name;
    public $email_from;
    public $email;
    public $email_cc;
    public $email_bcc;
    public $subject_name;
    public $hero_name;
    public $department;
    public $total_channel_cycle;
    public $total_no_channel_cycle;
    public $no_enter_cycle_percent;
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
        $this->hero_name    = $data->get('hero_name');
        $this->department = $data->get('department');
        $this->total_channel_cycle    = $data->get('total_channel_cycle');
        $this->total_no_channel_cycle    = $data->get('total_no_channel_cycle');
        $this->no_enter_cycle_percent    = $data->get('no_enter_cycle_percent');
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
            'hero_name' => $this->hero_name,
            'department' => $this->department,
            'total_channel_cycle' => $this->total_channel_cycle,
            'total_no_channel_cycle' => $this->total_no_channel_cycle,
            'no_enter_cycle_percent' => $this->no_enter_cycle_percent
        ];

        Mail::send('email.sendSummarizeNotificationEmail', array(
                "name" => $data["name"],
                "subject_name" => $data["subject_name"],
                "hero_name" => $data["hero_name"],
                "department" => $data["department"],
                "total_channel_cycle" => $data["total_channel_cycle"],
                "total_no_channel_cycle" => $data["total_no_channel_cycle"],
                "no_enter_cycle_percent" => $data["no_enter_cycle_percent"]
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
