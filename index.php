<?php
include('headerincludes.php');

//Log each index visit.
Write_Log('views',"Site has logged a page view.");
?>
<HTML>
    <HEAD>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="uploadify/jquery.uploadify.js"></script>
        <script src="js/jquery/jquery.growl.js" type="text/javascript"></script>
        <link href="css/jquery.growl.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="uploadify/uploadify.css" />

        <?php Functions::RefreshDivs(); Functions::RefreshDivs('showtime'); Functions::RefreshDivs('pointrefresh'); ?>
        <link href="css/frontend.css" rel="stylesheet" type="text/css">
        <?php $User = new User($_SESSION['ID']); $User->Display_Theme(); ?>
        <TITLE>
        Character Guide Creator
        </TITLE>
    </HEAD>

    <BODY>

        <div id="Top-Bar">
            <div class="Login_Area">
                <?php
                Navigation::write_Login();
                Navigation::catch_Login();
                ?>
            </div>
                <?php Navigation::write_Private(); ?>
        </div>

        <div id="BodyWrapper">

<?PHP
    $View = explode("_", $_GET['view']);
?>

        <!-- <div id="Header">
             <a href='/' class="Logo"></a> 
        </div> -->
        <br>

        <div id="Public-Navigation">
            <?php Navigation::write_Public(); ?>
        </div>
        <div id="Content">
            <?php Functions::Display_View(Functions::Get_View()); ?>
        </div>
    </BODY>
</HTML>
<?php

//Toasts::displayAllToasts();
if (!empty($User->Config_Settings["Show_Toasts"])) {
    if ($User->Config_Settings["Show_Toasts"] == 1) {
        Toasts::displayAllToasts();
    } else {
        Toasts::clearAllToasts();
    }
} else {
    Toasts::displayAllToasts();
}

?>
