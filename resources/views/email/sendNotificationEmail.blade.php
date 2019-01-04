<!DOCTYPE>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{ $subject_name }}</title>
    </head>
    <body style="font-family: Arial, Helvetica, sans-serif;">
        <div style="color:black;font-size:10pt">
            <h3><b></b>Dear {{ $name }},</b></h3>
                <div style='text-indent: 30px;'>
                    <p style="color:black">
                        This is automated emails from Alpha system.
                    </p>
                    <p>
                        <table width="80%" border="1" cellspacing="0" cellpadding="0">
                            <tr style="background-color:#F69022;color:white;font-size:10pt">
                                <td>Campaign Name</td>
                                <td>Channel</td>
                                <td>Issue</td>
                            </tr>

                            @foreach($campaign_name as $key => $name)
                                <tr style="color:black;font-size:10pt">
                                    <td><a href="{{ $link_campaign[$key] }}">{{ $campaign_name[$key] }}</a></td>
                                    <td><a href="{{ $link_channel[$key] }}">{{ $channel_name[$key] }}</a></td>
                                    <td>{{ $issue[$key] }}</td>
                                </tr>
                            @endforeach

                        </table>
                    </p>
                </div>
                <div style="color:black;font-size:10pt">
                    <p>
                        If you have any further questions, please feel free to contract Alpha Team.
                    </p>
                    <p>
                        Best regards,<br>
                        Alpha
                    </p>
                    <!--
                    <p>
                        Heroleads (Thailand) Co., Ltd.<br>
                        Sino-Thai Tower, 32/30, 9th Fl., Sukhumvit 21 Rd.(Asoke),<br>
                        Klongtoey Nua, Wattana, Bangkok 10110, Thailand<br>
                        P 02 258 1930 (For Finance department please use this number 02 258 1931)<br>
                        <a href="mailto:thailand@heroleads.com">E thailand@heroleads.com</a><br>
                        <a href="http://heroleads.co.th">W http://heroleads.co.th</a>
                    </p>
                -->
                </div>
        </div>
    </body>
</html>
