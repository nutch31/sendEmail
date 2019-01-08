<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\SummarizeNotificationEmail;
use App\SummarizeNotification;

class SummarizeNotificationEmailController extends Controller
{
    //
    public function __construct()
    {

    }

    public function summarizeNotificationEmail(Request $request)
    {
        dispatch(new SummarizeNotificationEmail($request));

        $html = view('email.sendSummarizeNotificationEmail', array(
            "name" => $request->get('name'),
            "subject_name" => $request->get('subject_name').' - '.date("Y-m-d"),
            "hero_name" => $request->get('hero_name'),
            "department" => $request->get('department'),
            "total_channel_cycle" => $request->get('total_channel_cycle'),
            "total_no_channel_cycle" => $request->get('total_no_channel_cycle'),
            "no_enter_cycle_percent" => $request->get('no_enter_cycle_percent')
        ));

        $summarizeNotification = new SummarizeNotification;
        $summarizeNotification->name = $request->get('name');
        $summarizeNotification->email_from = $request->get('email_from');
        $summarizeNotification->email = json_encode($request->get('email'));
        $summarizeNotification->email_cc = json_encode($request->get('email_cc'));
        $summarizeNotification->email_bcc = json_encode($request->get('email_bcc'));
        $summarizeNotification->subject_name = $request->get('subject_name').' - '.date("Y-m-d");
        $summarizeNotification->body_mail = $html;
        $summarizeNotification->status = 1;
        $summarizeNotification->save();

        return response(array(
            'Status' => 'Success'
        ), '200');
    }
}
