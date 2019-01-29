<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\VerifyLeadsEveryCampaignEmail as VFR;
use App\VerifyLeadsEveryCampaign;

class VerifyLeadsEveryCampaignEmailController extends Controller
{
    //
    public function __construct()
    {

    }

    public function verifyLeadsEveryCampaignEmail(Request $request)
    {
        $request = $request->all();

        $email_account_manager = array();
        $name_account_manager  = array();
        $email_relate          = array();
        $email_from            = array();
        $subject_name          = array();
        $email_bcc             = array();

        foreach($request as $key => $r)
        {
            if($r["lead_status"] == "Error")
            {
                $email_account_manager[$key] = $r["email_account_manager"];
                $name_account_manager[$key]  = $r["name_account_manager"];
                $email_from[$key]            = $r["email_from"];
                $subject_name[$key]          = $r["subject_name"];
                $email_bcc[$key]             = $r["email_bcc"];
            }
        }

        $email_account_manager       = array_values(array_unique($email_account_manager));
        $name_account_manager        = array_values(array_unique($name_account_manager));

        foreach($email_account_manager as $key => $e)
        {
            foreach($request as $keyR => $r)
            {
                if($r["lead_status"] == "Error")
                {
                    if($e == $r["email_account_manager"])
                    {
                        foreach($r["email"] as $keyE => $email)
                        {
                            $email_relate[$key][] = $email;
                        }
                    }
                }
            }

            $email_relate[$key]       = array_values(array_unique($email_relate[$key]));

            dispatch(new VFR($request, $email_relate[$key], $email_from[$key], $email_account_manager[$key], $name_account_manager[$key], $email_bcc[$key], $subject_name[$key]));

            $html = view('email.sendVerifyLeadsEveryCampaignEmail', array(
                "data" => $request,
                "email_relate" => $email_relate[$key],
                "email_from" => $email_from[$key],
                "email_account_manager" => $email_account_manager[$key],
                "name_account_manager" => $name_account_manager[$key],
                "email_bcc" => $email_bcc[$key],
                "subject_name" => $subject_name[$key]
            ));

            $verifyLeadsEveryCampaign = new VerifyLeadsEveryCampaign();
            $verifyLeadsEveryCampaign->name = json_encode($email_relate[$key]);
            $verifyLeadsEveryCampaign->email_from = $email_from[$key];
            $verifyLeadsEveryCampaign->email = json_encode($email_account_manager[$key]);
            $verifyLeadsEveryCampaign->email_cc = json_encode($email_relate[$key]);
            $verifyLeadsEveryCampaign->email_bcc = json_encode($email_bcc[$key]);
            $verifyLeadsEveryCampaign->subject_name = $subject_name[$key].' - '.date("Y-m-d");
            $verifyLeadsEveryCampaign->body_mail = $html;
            $verifyLeadsEveryCampaign->status = 1;
            $verifyLeadsEveryCampaign->save();

        }

        return response(array(
                    'Status' => 'Success'
                ), '200');

    }
}
