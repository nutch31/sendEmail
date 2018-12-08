<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendDailyEmail extends Model
{
    //
    protected $table = 'log_send_daily_email';
    protected $fillable = ['file_url', 'mime_type', 'extension', 'status', 'email_from', 'email', 'email_cc', 'email_bcc'];
}
