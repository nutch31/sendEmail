<!DOCTYPE>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>{{$subject_name}}</title>
    </head>
    <body style="font-family: Arial, Helvetica, sans-serif;">
        <div style="color:black;font-size:10pt">
            <h3><b></b>Dear
                    Khun {{$name_account_manager}},
            </b></h3>
                <div style='text-indent: 30px;font-size:20px;'>
                    <p style="color:red">
                        <b>
                            This is test automated emails from Alpha system.
                        </b>
                    </p>
                    <p>
                        <table width="100%" border="1" cellspacing="0" cellpadding="0">
                            <tr style="background-color:#F69022;color:white;font-size:10pt">
                                <td width="25%">Campaign Name</td>
                                <td width="25%">Error Description</td>
                                <td width="40%">Remark</td>
                                <td width="10%">Link</td>
                            </tr>

                                <?php

                                foreach($data as $d)
                                {
                                    if($d["lead_status"] == "Error")
                                    {
                                        if($d["email_account_manager"] == $email_account_manager)
                                        {
                                            if(isset($d["remark"]))
                                            {
                                                $count_remark = count($d["remark"]);
                                                $count_colspan = 0;
                                                foreach($d["remark"] as $keyRemark => $remark)
                                                {
                                                ?>
                                                    <tr style="color:black;font-size:10pt">
                                                        <?php if($count_colspan == 0){?>
                                                            <td rowspan={{$count_remark}}>{{$d["campaign_name"]}}</td>
                                                        <?php }?>
                                                            <td>{{$keyRemark}}</td>
                                                            <td>{!!$remark!!}</td>
                                                            <td><a href="{{$d["link"][$keyRemark]}}">Fix It</a></td>
                                                    </tr>
                                                <?php $count_colspan++;
                                                }
                                            }
                                        }
                                    }
                                }?>
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
