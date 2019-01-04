<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\NotificationEmail;
use App\Notification;

class NotificationEmailController extends Controller
{
    //
    public function __construct()
    {

    }

    public function notificationEmail(Request $request)
    {
        dispatch(new NotificationEmail($request));

        $html = view('email.sendNotificationEmail', array(
            "name" => $request->get('name'),
            "subject_name" => $request->get('subject_name').' - '.date("Y-m-d"),
            "campaign_name" => $request->get('campaign_name'),
            "channel_name" => $request->get('channel_name'),
            "issue" => $request->get('issue'),
            "link_campaign" => $request->get('link_campaign'),
            "link_channel" => $request->get('link_channel')
        ));

        $notification = new Notification;
        $notification->name = $request->get('name');
        $notification->email_from = $request->get('email_from');
        $notification->email = json_encode($request->get('email'));
        $notification->email_cc = json_encode($request->get('email_cc'));
        $notification->email_bcc = json_encode($request->get('email_bcc'));
        $notification->subject_name = $request->get('subject_name').' - '.date("Y-m-d");
        $notification->body_mail = $html;
        $notification->status = 1;
        $notification->save();

        return response(array(
            'Status' => 'Success'
        ), '200');
    }
}
