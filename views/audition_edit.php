<?php 
$CharacterGuide = new CharacterGuide();

$Parameters['Audio_File']="/audio/EDIT-344fgdfg.mp3";
$Parameters['Video_File']="/videos/EDIT-0403405405.avi";
$ID = $_GET['ID'];
$CharacterGuide->Edit_Audition($ID, $Parameters);