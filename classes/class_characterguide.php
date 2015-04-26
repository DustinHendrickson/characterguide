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

            $Scenes = $this->Get_All_Scenes_In_Project($ProjectID);
            foreach($Scenes as $Scene) {
                $this->Delete_Scene($Scene['ID']);
            }

        } else {
            Toasts::addNewToast('Project Delete ['.$ProjectID .'] encountered an error.','error');
        }

    }

    public function Rank_Project() {
        
    }

    public function Get_Global_Project_Selector($UserID) {
        $All_Projects = $this->Get_All_Projects_For_User($UserID);

        $Project_Select .= "<form action='' method='post' id='Project_ID_Form' onchange='document.forms.Project_ID_Form.submit()'>";
        $Project_Select .= "<b>Project:</b> <select id='Project_ID' name='Project_ID' >";
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

            $Characters = $this->Get_All_Characters_In_Scene($SceneID);

            foreach($Characters as $Character) {
                $this->Delete_Character($Character['ID']);
            }

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

            $Auditions = $this->Get_All_Auditions_For_Character($CharacterID);

            foreach($Auditions as $Audition) {
                $this->Delete_Audition($Audition['ID']);
            }
        } else {
            Toasts::addNewToast('Character Delete ['.$CharacterID .'] encountered an error.','error');
        }
    }

    public function Rank_Character() {
        
    }

    public function Get_Character_Selector($ProjectID) {
        $All_Characters = $this->Get_All_Characters_For_Project($ProjectID);

        $Character_Select .= "<select id='Character_ID' name='Character_ID' >";
        foreach($All_Characters as $Character) {
            $Selected = "";
            if($_SESSION['Character_ID'] == $Character['ID']) { $Selected = "selected"; }
            $Character_Select .= "<option {$Selected} value='{$Character['ID']}'> {$Character['Name']} </option>";
        }
        $Character_Select .= "</select>";

        return $Character_Select;
    }

    public function Get_Audition_Character_Selector($ProjectID, $AuditionID) {
        $All_Characters = $this->Get_All_Characters_For_Project($ProjectID);
        $Character_ID = $this->Get_Character_For_Audition($AuditionID)["Character_ID"];

        $Character_Select .= "<select id='Character_ID' name='Character_ID' >";
        foreach($All_Characters as $Character) {
            $Selected = "";
            if($Character_ID == $Character['ID']) { $Selected = "selected"; }
            $Character_Select .= "<option {$Selected} value='{$Character['ID']}'> {$Character['Name']} </option>";
        }
        $Character_Select .= "</select>";

        return $Character_Select;
    }

    public function Get_Search_Character_Selector($ProjectID) {
        $All_Characters = $this->Get_All_Characters_For_Project($ProjectID);

        $Character_Select .= "<select id='Search_Character_ID' name='Search_Character_ID' >";
         $Character_Select .=  "<option value='ALL'> All Characters </option>";
        foreach($All_Characters as $Character) {
            $Selected = "";
            if($_SESSION['Search_Character_ID'] == $Character['ID']) { $Selected = "selected"; }
            $Character_Select .= "<option {$Selected} value='{$Character['ID']}'> {$Character['Name']} </option>";
        }
        $Character_Select .= "</select>";

        return $Character_Select;
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

    public function Upload_Audition($AuditionID, $FileType, $FilePath) {
            $User = new User($_SESSION['ID']);

            // We check to make sure that there is no error in the process.
            if ($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
                echo "<hr><br>";
                Toasts::addNewToast('Something went wrong with the file upload. Please try again.','error');
                Write_Log("upload", "UPLOAD:ERROR " . $User->Username . " tried uploading file " . $_FILES["file"]["name"] . " and ran into error " . $_FILES["file"]["error"]);
            } else {

                // Make sure there is not already a file with that name on the system.
                if (file_exists("/var/www/uploads/" . $_FILES["file"]["name"])) {
                    echo "ERROR: " . $_FILES["file"]["name"] . " already exists. ";
                    Toasts::addNewToast('That file already exists, please pick a different file or rename it.','error');
                    Write_Log("upload", "UPLOAD:ERROR " . $User->Username . " tried uploading file " . $_FILES["file"]["name"] . " but it already exists.");
                } else {

                    // Everything looks good so we upload the file and output some statistics for the user.
                    echo "<b> File Stats </b><br>";
                    echo "<b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
                    echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
                    echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br><br>";

                    // Here we move the file from the tmp directory to the server uploads directory and link the file to the user.
                    move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/uploads/" . $_FILES["file"]["name"]);
                    echo "<b>Link to file:</b> " . "<a target='_blank' href='https://dustinhendrickson.com/uploads/" . $_FILES["file"]["name"] . "'> https://dustinhendrickson.com/uploads/" . $_FILES["file"]["name"] ."</a>";
                    Toasts::addNewToast('File upload was successful.','success');
                    Write_Log("upload", "UPLOAD:SUCCESS " . $User->Username . " successfully uploaded file " . $_FILES["file"]["name"]);
                }

            echo "<hr><br>";
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

    public function Get_First_Project_For_User($UserID) {
        $SQL = "SELECT * FROM projects WHERE ID = (SELECT MIN(ID) FROM projects WHERE Owner_ID = :Owner_ID)";
        $Array = array(':Owner_ID' => $UserID);
        $Result = $this->Connection->Custom_Query($SQL, $Array);

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

    public function Get_All_Scenes_For_Project($ProjectID) {
        $SQL = "SELECT * FROM scenes WHERE Project_ID = :Project_ID";
        $Array = array(':Project_ID' => $ProjectID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
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

    public function Get_Character_For_Audition($Audition_ID) {
        $SQL = "SELECT Character_ID FROM auditions WHERE ID = :ID";
        $Array = array(':ID' => $Audition_ID);
        $Result = $this->Connection->Custom_Query($SQL, $Array);

        return $Result;
    }

    public function Get_All_Auditions_For_Character($CharacterID) {
        $SQL = "SELECT * FROM auditions WHERE Character_ID = :Character_ID";
        $Array = array(':Character_ID' => $CharacterID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }

    public function Get_All_Auditions_For_User($UserID) {
        $SQL = "SELECT * FROM auditions WHERE Owner_ID = :Owner_ID";
        $Array = array(':Owner_ID' => $UserID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }

    public function Get_All_Auditions_For_Project($ProjectID) {
        $SQL = "SELECT * FROM auditions WHERE Project_ID = :Project_ID";
        $Array = array(':Project_ID' => $ProjectID);
        $Result = $this->Connection->Custom_Query($SQL, $Array, true);

        return $Result;
    }

    public function Get_Project_Count($UserID) {
        $SQL = "SELECT COUNT(*) FROM projects WHERE Owner_ID = :Owner_ID";
        $Array = array(':Owner_ID' => $UserID);
        $Result = $this->Connection->Custom_Count_Query($SQL, $Array);

        return $Result[0];
    }

    public function Get_Scene_Count($ProjectID) {
        $SQL = "SELECT COUNT(*) FROM scenes WHERE Project_ID = :Project_ID";
        $Array = array(':Project_ID' => $ProjectID);
        $Result = $this->Connection->Custom_Count_Query($SQL, $Array);

        return $Result[0];
    }

    public function Get_Character_Count($ProjectID) {
        $SQL = "SELECT COUNT(*) FROM characters WHERE Project_ID = :Project_ID";
        $Array = array(':Project_ID' => $ProjectID);
        $Result = $this->Connection->Custom_Count_Query($SQL, $Array);

        return $Result[0];
    }

    public function Get_Audition_Count($ProjectID) {
        $SQL = "SELECT COUNT(*) FROM auditions WHERE Project_ID = :Project_ID";
        $Array = array(':Project_ID' => $ProjectID);
        $Result = $this->Connection->Custom_Count_Query($SQL, $Array);

        return $Result[0];
    }

}
