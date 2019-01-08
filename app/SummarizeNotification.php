<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SummarizeNotification extends Model
{
    //
    protected $table = "summarize_notification_email";
    protected $fillable = ['name', 'email_from', 'email', 'email_cc', 'email_bcc', 'subject_name', 'body_mail', 'status'];
}
