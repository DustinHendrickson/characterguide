<?php 
$CharacterGuide = new CharacterGuide();

$Parameters['Title']="EDIT SCENE";
$ID = $_GET['ID'];
$CharacterGuide->Edit_Scene($ID, $Parameters);