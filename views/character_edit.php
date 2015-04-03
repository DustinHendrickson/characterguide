<?php 
$CharacterGuide = new CharacterGuide();

$Parameters['Name']="EDIT Jo Bob";
$Parameters['Description']="EDIT Jo Bob is a small town ganster.";
$Parameters['In_Scenes']="1";
$Parameters['Gender']="Female";
$ID = $_GET['ID'];
$CharacterGuide->Edit_Character($ID, $Parameters);