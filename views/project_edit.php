<?php 
$CharacterGuide = new CharacterGuide();

$Parameters['Title']="EDIT Project";
$Parameters['Type']="User";
$ID = $_GET['ID'];
$CharacterGuide->Edit_Project($ID, $Parameters);