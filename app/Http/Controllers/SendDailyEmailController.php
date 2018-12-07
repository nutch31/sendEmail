<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\SendDailyEmail;
use Storage;

class SendDailyEmailController extends Controller
{
    //
    public function index()
    {
        //return reponse()->json();
        return 'TEST';
    }

    public function sendEmail(Request $request)
    {
        //Config fileUrl, mimeType, Emails
        /*
        $fileUrl    = $request['fileUrl'];
        $mimeType   = $request['mimeType'];
        $email_from = $request['email_from'];
        $email      = $request['email'];
        $email_cc   = $request['email_cc'];
        $email_bcc  = $request['email_bcc'];
        $dir['name'] = 'TEST MAIL';
        */

        $fileUrl    = 'https://docs.google.com/spreadsheets/d/1PediIgoD_LKppgwm4jF5srgQN_SqTHilKazkS_AYmaQ/edit?pli=1#gid=152349423';
        $mimeType   = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        $email_from = 'admin.th@heroleads.com';
        $email      = 'nut@heroleads.com';
        $email_cc   = 'nut_ch31@hotmail.com';
        $email_bcc  = 'nutnutnutnutnutnutnutnutnutnut@gmail.com';
        $dir['name'] = 'TEST MAIL';

        //Find extension mimeType
        $extension = $this->checkExtension($mimeType);

        //Find Basename
        $array          = explode('/d/', $fileUrl);
        $array_basename = explode('/', $array[1]);
        $basename       = $array_basename[0];

        $service = Storage::cloud()->getAdapter()->getService();

        //$file = $service->files->get($basename);

        $export = $service->files->export($basename, $mimeType, array(
            'alt' => 'media'
        ));

        $contentFile = $export->getBody();

        $data = [
            'email_from' => $email_from,
            'email' => $email,
            'email_cc' => $email_cc,
            'email_bcc' => $email_bcc,
            'contentFile' => $contentFile,
            'dirname' => $dir['name'],
            'extension' => $extension
        ];

       Mail::send('email.sendDailyEmail', $data, function ($message) use ($data)
        {
            $message->from($data['email_from']);
            $message->to($data['email']);
            if(!empty($data['email_cc']))
            {
                 $message->cc($data['email_cc']);
            }
            if(!empty($data['email_bcc']))
            {
                $message->bcc($data['email_bcc']);
            }
            $message->subject('FYI : Daily Report Mail : '.$data['dirname'].'_'.date("Ymd").'.'.$data['extension']);
            $message->attachData($data['contentFile'], $data['dirname'].'_'.date("Ymd").'.'.$data['extension']);
        });

        if(count(Mail::failures()) > 0)
        {
            $content = 'Failed to send Email!';
        }
        else
        {
            $content = 'Success to send Email!';
        }

        /*
        $SendDailyEmail = new SendDailyEmail();

        $email = json_encode($email);
        $email_cc = json_encode($email_cc);
        $email_bcc = json_encode($email_bcc);

        $SendDailyEmail->file_url = $fileUrl;
        $SendDailyEmail->mime_type = $mimeType;
        $SendDailyEmail->extension = $extension;
        $SendDailyEmail->content = $content;
        $SendDailyEmail->status = 1;
        $SendDailyEmail->email_from = $email_from;
        $SendDailyEmail->email = $email;
        $SendDailyEmail->email_cc = $email_cc;
        $SendDailyEmail->email_bcc = $email_bcc;

        $SendDailyEmail->save();
        */

        return response(array(
            'Status' => 'Success'
        ), '200');
    }

    public function checkExtension($mimeType)
    {
        $extension = array(
            'application/msword' => 'doc' ,
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.template' => 'dotx',
            'application/vnd.ms-excel' => 'xls',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.template' => 'xltx',
            'application/vnd.ms-excel.sheet.macroEnabled.12' => 'xlsm',
            'application/vnd.ms-excel.template.macroEnabled.12' => 'xltm',
            'application/vnd.ms-excel.addin.macroEnabled.12' => 'xlam',
            'application/vnd.ms-excel.sheet.binary.macroEnabled.12' => 'xlsb',
            'application/vnd.ms-powerpoint' => 'ppt',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
            'application/vnd.openxmlformats-officedocument.presentationml.template' => 'potx',
            'application/vnd.openxmlformats-officedocument.presentationml.slideshow' => 'ppsx',
            'application/vnd.ms-powerpoint.addin.macroEnabled.12' => 'ppam',
            'application/vnd.ms-powerpoint.presentation.macroEnabled.12' => 'pptm',
            'application/vnd.ms-powerpoint.slideshow.macroEnabled.12' => 'ppsm',
            'text/plain' => 'txt',
            'text/html' => 'html',
            'text/css' => 'css',
            'application/javascript' => 'js',
            'application/json' => 'json' ,
            'application/xml' => 'xml',
            'application/x-shockwave-flash' => 'swf' ,
            'video/x-flv' => 'flv',
            // images
            'image/png' => 'png' ,
            'image/jpeg' => 'jpe' ,
            'image/jpeg' => 'jpeg' ,
            'image/jpeg' => 'jpg' ,
            'image/gif' => 'gif' ,
            'image/bmp' => 'bmp' ,
            'image/vnd.microsoft.icon' => 'ico',
            'image/tiff' =>  'tiff' ,
            'image/tiff' =>  'tif' ,
            'image/svg+xml'  => 'svg',
            'image/svg+xml'=> 'svgz' ,
            // archives
            'application/zip' =>  'zip',
            'application/x-rar-compressed' =>  'rar',
            'application/x-msdownload' =>  'exe' ,
            'application/x-msdownload'=>  'msi' ,
            'application/vnd.ms-cab-compressed' =>  'cab',
            // audio/video
            'audio/mpeg'  =>  'mp3',
            'video/quicktime'  => 'qt',
            'video/quicktime'  =>  'mov',
            // adobe
            'application/pdf'  =>  'pdf',
            'image/vnd.adobe.photoshop'  =>  'psd',
            'application/postscript' => 'ai' ,
            'application/postscript' =>  'eps',
            'application/postscript' =>  'ps',
            // ms office
            'application/msword'  =>  'doc',
            'application/rtf' =>  'rtf' ,
            'application/vnd.ms-excel' =>  'xls',
            'application/vnd.ms-powerpoint' =>  'ppt',
            // open office
            'application/vnd.oasis.opendocument.text'  =>  'odt',
            'application/vnd.oasis.opendocument.spreadsheet'  =>  'ods',
        );

        if (array_key_exists($mimeType, $extension))
        {
            return $extension[$mimeType];
        }
    }
}
