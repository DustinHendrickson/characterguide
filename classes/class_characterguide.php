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
    public function Create_Project($Parameters) { // Parameters accepted, Title, Type

        if ($Parameters) {
                $Config_Array = array();
                $Parameters["Owner_ID"] = $this->User->ID;
                $SQL = "INSERT INTO projects (";

                $Number_Of_Parameters = count($Parameters);
                $i = 0;

                // Loop through each parameter to produce an Array and String to run an SQL query.
                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= " " . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= ") VALUES (";

                $i = 0;

                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= " :" . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= ")";

                $Results = $this->Connection->Custom_Execute($SQL, $Config_Array);
        }

        if ($Results) {
            Toasts::addNewToast('Project added successfully.','success');
        } else {
            Toasts::addNewToast('Project add encountered an error.','error');
        }
    }

    public function Edit_Project($ProjectID, $Parameters) { // Parameters accepted, Title, Type

        if ($Parameters) {
                $Config_Array = array();
                $SQL = "UPDATE projects SET ";

                $Number_Of_Parameters = count($Parameters);
                $i = 0;

                // Loop through each parameter to produce an Array and String to run an SQL query.
                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= $ParameterName ."=:" . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }


                $SQL .= " WHERE ";

                $SQL .= "ID=" . $ProjectID;

                $Results = $this->Connection->Custom_Execute($SQL, $Config_Array);
        }

        if ($Results) {
            Toasts::addNewToast('Project edited successfully.','success');
        } else {
            Toasts::addNewToast('Project edit encountered an error.','error');
        }

    }

    public function Delete_Project($ProjectID) {
        $Post_Array = array (':ID'=>$ProjectID);
        $Results = $this->Connection->Custom_Execute("DELETE FROM projects WHERE ID=:ID", $Post_Array);

        if ($Results){
            Toasts::addNewToast('Project Delete ['.$ProjectID .'] successfully deleted.','success');
        } else {
            Toasts::addNewToast('Project Delete ['.$ProjectID .'] encountered an error.','error');
        }
    }

    public function Rank_Project() {
        
    }

    public function Get_Global_Project_Selector($UserID) {
        $All_Projects = $this->Get_All_Projects_For_User($UserID);

        $Project_Select .= "<form action='' method='post' id='Project_ID_Form' onchange='document.forms.Project_ID_Form.submit()'>";
        $Project_Select .= "<select id='Project_ID' name='Project_ID' >";
        foreach($All_Projects as $Project) {
            $Selected = "";
            if($_SESSION['Project_ID'] == $Project['ID']) { $Selected = "selected"; }
            $Project_Select .= "<option {$Selected} value='{$Project['ID']}'> {$Project['Title']} </option>";
        }
        $Project_Select .= "</select>";
        $Project_Select .= "</form>";

        return $Project_Select;
    }

    public function Get_Project_Selector($UserID) {
        $All_Projects = $this->Get_All_Projects_For_User($UserID);

        $Project_Select .= "<select id='Project_ID' name='Project_ID' >";
        foreach($All_Projects as $Project) {
            $Selected = "";
            if($_SESSION['Project_ID'] == $Project['ID']) { $Selected = "selected"; }
            $Project_Select .= "<option {$Selected} value='{$Project['ID']}'> {$Project['Title']} </option>";
        }
        $Project_Select .= "</select>";

        return $Project_Select;
    }

    // SCENES ===========================================
    public function Create_Scene($Parameters) { // Parameters accepted, Title, Project_ID

        if ($Parameters) {
                $Config_Array = array();
                $SQL = "INSERT INTO scenes (";

                $Number_Of_Parameters = count($Parameters);
                $i = 0;

                // Loop through each parameter to produce an Array and String to run an SQL query.
                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= " " . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= ") VALUES (";

                $i = 0;

                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= " :" . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= ")";

                $Results = $this->Connection->Custom_Execute($SQL, $Config_Array);
        }

        if ($Results) {
            Toasts::addNewToast('Scene added successfully.','success');
        } else {
            Toasts::addNewToast('Scene add encountered an error.','error');
        }
    }

    public function Edit_Scene($SceneID, $Parameters) {// Parameters accepted, Title
            if ($Parameters) {
                $Config_Array = array();
                $SQL = "UPDATE scenes SET ";

                $Number_Of_Parameters = count($Parameters);
                $i = 0;

                // Loop through each parameter to produce an Array and String to run an SQL query.
                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= $ParameterName ."=:" . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= " WHERE ";

                $SQL .= "ID=" . $SceneID;

                $Results = $this->Connection->Custom_Execute($SQL, $Config_Array);
        }

        if ($Results) {
            Toasts::addNewToast('Scene edited successfully.','success');
        } else {
            Toasts::addNewToast('Scene edit encountered an error.','error');
        }
    }

    public function Delete_Scene($SceneID) {
        $Post_Array = array (':ID'=>$SceneID);
        $Results = $this->Connection->Custom_Execute("DELETE FROM scenes WHERE ID=:ID", $Post_Array);

        if ($Results){
            Toasts::addNewToast('Scene Delete ['.$SceneID .'] successfully deleted.','success');
        } else {
            Toasts::addNewToast('Scene Delete ['.$SceneID .'] encountered an error.','error');
        }
    }

    public function Rank_Scene() {
        
    }

    // CHARACTERS =======================================
    public function Create_Character($Parameters) {// Parameters accepted, Name,Description,In_Scenes,Gender

        if ($Parameters) {
                $Config_Array = array();
                $SQL = "INSERT INTO characters (";

                $Number_Of_Parameters = count($Parameters);
                $i = 0;

                // Loop through each parameter to produce an Array and String to run an SQL query.
                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= " " . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= ") VALUES (";

                $i = 0;

                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= " :" . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= ")";

                $Results = $this->Connection->Custom_Execute($SQL, $Config_Array);
        }

        if ($Results) {
            Toasts::addNewToast('Character added successfully.','success');
        } else {
            Toasts::addNewToast('Character add encountered an error.','error');
        }
    }


    public function Edit_Character($CharacterID, $Parameters) {// Parameters accepted, Name,Description,In_Scenes,Gender

        if ($Parameters) {
                $Config_Array = array();
                $SQL = "UPDATE characters SET ";

                $Number_Of_Parameters = count($Parameters);
                $i = 0;

                // Loop through each parameter to produce an Array and String to run an SQL query.
                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= $ParameterName ."=:" . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= " WHERE ";

                $SQL .= "ID=" . $CharacterID;

                $Results = $this->Connection->Custom_Execute($SQL, $Config_Array);
        }

        if ($Results) {
            Toasts::addNewToast('Character edited successfully.','success');
        } else {
            Toasts::addNewToast('Character edit encountered an error.','error');
        }
    }

    public function Delete_Character($CharacterID) {
        $Post_Array = array (':ID'=>$CharacterID);
        $Results = $this->Connection->Custom_Execute("DELETE FROM characters WHERE ID=:ID", $Post_Array);

        if ($Results){
            Toasts::addNewToast('Character Delete ['.$CharacterID .'] successfully deleted.','success');
        } else {
            Toasts::addNewToast('Character Delete ['.$CharacterID .'] encountered an error.','error');
        }
    }

    public function Rank_Character() {
        
    }

    // AUDITIONS ========================================
    public function Create_Audition($Parameters) {// Parameters accepted, Audio_File, Video_File, Character_ID

        if ($Parameters) {
                $Config_Array = array();
                $SQL = "INSERT INTO auditions (";

                $Number_Of_Parameters = count($Parameters);
                $i = 0;

                // Loop through each parameter to produce an Array and String to run an SQL query.
                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= " " . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= ") VALUES (";

                $i = 0;

                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= " :" . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= ")";

                $Results = $this->Connection->Custom_Execute($SQL, $Config_Array);
        }

        if ($Results) {
            Toasts::addNewToast('Audition added successfully.','success');
        } else {
            Toasts::addNewToast('Audition add encountered an error.','error');
        }
    }

    public function Edit_Audition($AuditionID, $Parameters) {// Parameters accepted, Audio_File, Video_File, Character_ID

        if ($Parameters) {
                $Config_Array = array();
                $SQL = "UPDATE auditions SET ";

                $Number_Of_Parameters = count($Parameters);
                $i = 0;

                // Loop through each parameter to produce an Array and String to run an SQL query.
                foreach ($Parameters as $ParameterName => $ParameterValue) {
                    $i++;

                    $KeyValue = ":". $ParameterName;
                    $Config_Array[$KeyValue] = $ParameterValue;
                    $SQL .= $ParameterName ."=:" . $ParameterName;

                    // Here we check if the parameter is the last one, if so we don't add a command in the SQL.
                    if ($i != $Number_Of_Parameters) {
                        $SQL .= ", ";
                    }
                }

                $SQL .= " WHERE ";

                $SQL .= "ID=" . $AuditionID;

                $Results = $this->Connection->Custom_Execute($SQL, $Config_Array);
        }

        if ($Results) {
            Toasts::addNewToast('Audition edited successfully.','success');
        } else {
            Toasts::addNewToast('Audition edit encountered an error.','error');
        }
    }

    public function Delete_Audition($AuditionID) {
        $Post_Array = array (':ID'=>$AuditionID);
        $Results = $this->Connection->Custom_Execute("DELETE FROM auditions WHERE ID=:ID", $Post_Array);

        if ($Results){
            Toasts::addNewToast('Audition Delete ['.$AuditionID .'] successfully deleted.','success');
        } else {
            Toasts::addNewToast('Audition Delete ['.$AuditionID .'] encountered an error.','error');
        }
    }

    public function Rank_Audition() {
        
    }


    public function Display_Templated_Object($Parameters, $Template) {

        //Template Engine
        //This is where we setup the ID's
        //and their values that will get replaced.
        foreach($Parameters as $ParameterKey => $ParameterValue){
            $Template_Replacement[$ParameterKey] = $ParameterValue;
        }

        //Replace the template strings with their values.
        $Template_Return = str_replace(array_keys($Template_Replacement),array_values($Template_Replacement),$Template);

        echo $Template_Return;

    }

    //=========================================================
    public function Get_All_Projects_For_User($UserID) {
        $SQL = "SELECT * FROM projects WHERE Owner_ID = :Owner_ID";
        $Array = array(':Owner_ID' => $UserID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }

    public function Get_All_Scenes_In_Project($ProjectID) {
        $SQL = "SELECT * FROM scenes WHERE Project_ID = :Project_ID";
        $Array = array(':Project_ID' => $ProjectID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }

    public function Get_All_Scene_Info($SceneID) {
        $SQL = "SELECT * FROM scenes WHERE ID = :SceneID";
        $Array = array(':SceneID' => $SceneID);
        $Result = $this->Connection->Custom_Query($SQL, $Array);

        return $Result;
    }

    public function Get_All_Scenes_For_User($UserID) {
        $SQL = "SELECT scenes.ID, scenes.Title, scenes.Project_ID, projects.Owner_ID FROM scenes INNER JOIN projects on scenes.Project_ID = projects.ID WHERE projects.Owner_ID = :User_ID";
        $Array = array(':User_ID' => $UserID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }


    public function Get_All_Scenes_For_Character($CharacterID) {
        $SQL = "SELECT * FROM characters WHERE ID = :ID";
        $Array = array(':ID' => $CharacterID);
        $Result = $this->Connection->Custom_Query($SQL, $Array);

        $Scene_Array = explode(",", $Result['In_Scenes']);

        return $Scene_Array;
    }

    public function Get_All_Characters_In_Scene($SceneID) {
        $SQL = "SELECT * FROM characters WHERE FIND_IN_SET( :In_Scenes, In_Scenes )";
        $Array = array(':In_Scenes' => $SceneID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }

    public function Get_All_Characters_For_User($UserID) {
        $SQL = "SELECT * FROM characters WHERE Owner_ID = :Owner_ID";
        $Array = array(':Owner_ID' => $UserID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }

    public function Get_All_Characters_For_Project($Project_ID) {
        $SQL = "SELECT * FROM characters WHERE Project_ID = :Project_ID";
        $Array = array(':Project_ID' => $Project_ID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }

    public function Get_All_Auditions_For_Character($CharacterID) {
        $SQL = "SELECT * FROM auditions WHERE Character_ID = :Character_ID";
        $Array = array(':Character_ID' => $CharacterID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }

}
