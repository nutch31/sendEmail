<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
    protected $table = "notification_email";
    protected $fillable = ['name', 'email_from', 'email', 'email_cc', 'email_bcc', 'subject_name', 'body_mail', 'status'];
}
