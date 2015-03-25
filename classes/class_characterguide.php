<?php

class CharacterGuide
{
    //Internal Variables
    private $Connection;
    private $User;


    // Construction Method
    function __construct()
    {
        $this->Connection = new Connection();
        $this->User = new User($_SESSION['ID']);
    }

    // PROJECTS ==========================================
    public function Create_Project() {

    }

    public function Edit_Project() {
        
    }

    public function Delete_Project() {
        
    }

    public function Rank_Project() {
        
    }

    // SCENES ===========================================
    public function Create_Scene() {

    }

    public function Edit_Scene() {
        
    }

    public function Delete_Scene() {
        
    }

    public function Rank_Scene() {
        
    }

    // CHARACTERS =======================================
    public function Create_Character() {

    }

    public function Edit_Character() {
        
    }

    public function Delete_Character() {
        
    }

    public function Rank_Character() {
        
    }

    // AUDITIONS ========================================
    public function Create_Audition() {

    }

    public function Edit_Audition() {
        
    }

    public function Delete_Audition() {
        
    }

    public function Rank_Audition() {
        
    }

}
