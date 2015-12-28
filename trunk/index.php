<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Cartoonize your profile picture!</title>
        <link type="text/css" href="css/cupertino/jquery-ui-1.7.2.custom.css" rel="stylesheet" />
        <script type="text/javascript" src="js/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>


        <script type="text/javascript">
            function cartoonizeImage() {
                showDialog();
                $("#cartoonized_pic").
                    load(function() {$("#cartoonized_pic").css("display", "inline"); hideDialog();}).
                    attr("src", "cartoonfy.php?source=" + $("#source_pic").attr("src"));
            }

            function hideDialog() {
                $("#dialog").dialog("close");
            }

            function showDialog() {
                $("#dialog").dialog({
                    bgiframe: true,
                    height: 140,
                    modal: true
                });
            }
        </script>

        






    </head>
    <body>


        <div id="dialog" title="Basic modal dialog">
            <p>Adding the modal overlay screen makes the dialog look more prominent because it dims out the page content.</p>
        </div>
        <?php
        // the facebook client library
        include_once "php/facebook.php";
        include_once "config.php";
        $facebook = new Facebook(ApplicationInfo::APY_KEY,
            ApplicationInfo::SECRET_KEY);
        //$facebook->require_frame();
        //$user = $facebook->require_login();

        //$userInfo = $facebook->api_client->users_getInfo($user, 'pic_big');
        $userInfo = array(0 => array("pic_big" => "http://127.0.0.1/FacebookCartoonifier/pic00153.jpg",
            "uid" => 1402362352));

        ?>

        <img id="source_pic" src="<?= $userInfo[0]['pic_big'] ?>" alt="Your profile pic"/>
        <button onclick="cartoonizeImage()">See your pic cartoonified!</button>
        <img id="cartoonized_pic" style="display:none" src="" alt=""/>
    </body>
</html>
