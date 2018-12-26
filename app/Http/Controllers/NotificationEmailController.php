<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\NotificationEmail;

class NotificationEmailController extends Controller
{
    //
    public function __construct()
    {

    }

    public function notificationEmail(Request $request)
    {
        dispatch(new NotificationEmail($request));

        return response(array(
            'Status' => 'Success'
        ), '200');
    }
}
