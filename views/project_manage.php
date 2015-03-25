<?php
Functions::Check_User_Permissions_Redirect('User');

$User = new User($_SESSION['ID']);
$View = Functions::Get_View();
?>
>> Create a new project
<br>
>> Manage project