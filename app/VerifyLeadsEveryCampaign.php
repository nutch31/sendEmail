<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerifyLeadsEveryCampaign extends Model
{
    //
    protected $table = "verify_leads_every_campaign";
    protected $fillable = ['name', 'email_from', 'email', 'email_cc', 'email_bcc', 'subject_name', 'body_mail', 'status'];
}
