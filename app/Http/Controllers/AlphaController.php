<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ResetPasswordEmail;
use App\ResetPassword;

class AlphaController extends Controller
{
    //
    public function __construct()
    {

    }

    public function resetPassword(Request $request)
    {

        dispatch(new ResetPasswordEmail($request));

        $html = view('email.sendResetPasswordEmail', array(
            "name" => $request->get('name'),
            "subject_name" => $request->get('subject_name'),
            "url" => $request->get('url')
        ));

        $resetpassword = new ResetPassword;
        $resetpassword->name = $request->get('name');
        $resetpassword->email_from = $request->get('email_from');
        $resetpassword->email = $request->get('email');
        $resetpassword->subject_name = $request->get('subject_name');
        $resetpassword->body_mail = $html;
        $resetpassword->status = 1;
        $resetpassword->save();

        return response(array(
            'Status' => 'Success'
        ), '200');

    }
}
