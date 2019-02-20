<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    //
    protected $table = "reset_password_email";
    protected $fillable = ['name', 'email_from', 'email', 'subject_name', 'body_mail', 'status'];
}
