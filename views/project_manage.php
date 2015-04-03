<?php
Functions::Check_User_Permissions_Redirect('User');

$User = new User($_SESSION['ID']);
$View = Functions::Get_View();
?>
<b>PROJECTS</b><br>
>> <a href='?view=project_creator'> Create a new project</a>
<br>
>> <a href='?view=project_edit&ID=1'>Edit project</a>
<br>
>> <a href='?view=project_delete&ID=1'>Delete project</a>
<hr>
<b>SCENES</b><br>
>> <a href='?view=scene_creator'> Create a new scene</a>
<br>
>> <a href='?view=scene_edit&ID=1'>Edit scene</a>
<br>
>> <a href='?view=scene_delete&ID=1'>Delete scene</a>
<hr>
<b>CHARACTERS</b><br>
>> <a href='?view=character_creator'> Create a new character</a>
<br>
>> <a href='?view=character_edit&ID=1'>Edit character</a>
<br>
>> <a href='?view=character_delete&ID=1'>Delete character</a>
<hr>
<b>AUDITIONS</b><br>
>> <a href='?view=audition_creator'> Create a new audition</a>
<br>
>> <a href='?view=audition_edit&ID=1'>Edit audition</a>
<br>
>> <a href='?view=audition_delete&ID=1'>Delete audition</a>
<br>
<br>
<hr>
<?php

$CharacterGuide = new CharacterGuide();

$All_Projects = $CharacterGuide->Get_All_Projects_For_User(1);
$All_Scenes = $CharacterGuide->Get_All_Scenes_In_Project(1);
$All_Characters = $CharacterGuide->Get_All_Characters_In_Scene(1);
$All_Auditions = $CharacterGuide->Get_All_Auditions_For_Character(1);

echo "<b>PROJECTS</b><br>";
foreach($All_Projects as $Project) {
    echo $Project['ID'] . "<br>";
    echo $Project['Title'] . "<br>";
    echo $Project['Type'] . "<br>";
    echo $Project['Owner_ID'] . "<br><br>";
}
echo "<b>SCENES</b><br>";
foreach($All_Scenes as $Scene) {
    echo $Scene['ID'] . "<br>";
    echo $Scene['Title'] . "<br>";
    echo $Scene['Project_ID'] . "<br><br>";
}
echo "<b>CHARACTERS</b><br>";
foreach($All_Characters as $Character) {
    echo $Character['ID'] . "<br>";
    echo $Character['Name'] . "<br>";
    echo $Character['Description'] . "<br>";
    echo $Character['In_Scenes'] . "<br>";
    echo $Character['Gender'] . "<br><br>";
}
echo "<b>AUDITIONS</b><br>";
foreach($All_Auditions as $Audition) {
    echo $Audition['ID'] . "<br>";
    echo $Audition['Audio_File'] . "<br>";
    echo $Audition['Video_File'] . "<br>";
    echo $Audition['Character_ID'] . "<br><br>";
}