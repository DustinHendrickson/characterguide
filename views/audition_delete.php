<?php 
$CharacterGuide = new CharacterGuide();

$ID = $_GET['ID'];
$CharacterGuide->Delete_Audition($ID);