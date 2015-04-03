<?php 
$CharacterGuide = new CharacterGuide();

$Parameters['Name']="Jo Bob";
$Parameters['Description']="Jo Bob is a small town ganster.";
$Parameters['In_Scenes']="1";
$Parameters['Gender']="Male";
$CharacterGuide->Create_Character($Parameters);