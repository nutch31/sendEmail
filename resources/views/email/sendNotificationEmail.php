<!DOCTYPE>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Report Daily Notification Email From Alpha</title>
    </head>
    <body>
        <div>
            <h1>Dear Customer</h1>
            <div style='text-indent: 30px;'>
                <p>
                    <b>This is an automatic email. </b>
                </p>
                    <?php
                    foreach($campaign_name as $name){
                    ?>
                    <p>
                        <?php echo $name;?>
                    </p>
                    <?php
                    }
                    ?>
            </div>
            <hr>
            <div style='color:FFA500'>
                <p>
                    <b>Heroleads (Thailand) Co., Ltd.</b>
                </p>
            </div>
    </body>
</html>
