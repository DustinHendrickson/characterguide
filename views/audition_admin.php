<?php

    Functions::Check_User_Permissions_Redirect("User");
    $User = new User($_SESSION['ID']);

    $CharacterGuide = new CharacterGuide();

    if (isset($_POST['Project_ID'])) {
        $_SESSION['Project_ID'] = $_POST['Project_ID'];
    } else { 
        if (!isset($_SESSION['Project_ID'])) {
            $_SESSION['Project_ID'] = $CharacterGuide->Get_First_Project_For_User($_SESSION['ID'])['ID']; 
        }
    }
    
    if ($CharacterGuide->Get_Project_Count($_SESSION['ID']) > 0) {
        if ($CharacterGuide->Get_Character_Count($_SESSION['Project_ID']) > 0) {

            echo $CharacterGuide->Get_Global_Project_Selector($_SESSION['ID']);

            //Logic to perform based on post data.
            $String_Protector_Array = array("<script","</script>","<source","<audio","('","')", "window.location", "onerror=");
            switch ($_POST['Mode'])
            {
                case 'Edit':
                    $CharacterGuide = new CharacterGuide();
                    $Passed_Parameters['Notes'] = str_replace($String_Protector_Array,"",$_POST['Notes']);
                    $Passed_Parameters['Character_ID'] = str_replace($String_Protector_Array,"",$_POST['Character_ID']);

                    $CharacterGuide->Edit_Audition($_POST['ID'], $Passed_Parameters);
                    break;

                case 'Add':
                    $CharacterGuide = new CharacterGuide();
                    $Passed_Parameters['Notes'] = str_replace($String_Protector_Array,"",$_POST['Notes']);
                    $Passed_Parameters['Audio_File'] = str_replace($String_Protector_Array,"",$_FILES['Audio_File']["name"]);
                    $Passed_Parameters['Video_File'] = str_replace($String_Protector_Array,"",$_FILES['Video_File']["name"]);
                    $Passed_Parameters['Project_ID'] = str_replace($String_Protector_Array,"",$_SESSION['Project_ID']);
                    $Passed_Parameters['Character_ID'] = str_replace($String_Protector_Array,"",$_POST['Character_ID']);
                    $Passed_Parameters['Owner_ID'] = $_SESSION['ID'];
                    $CharacterGuide->Create_Audition($Passed_Parameters);
                    break;

                case 'Delete':
                    $CharacterGuide = new CharacterGuide();
                    $CharacterGuide->Delete_Audition($_POST['ID']);
                    break;
                case 'Search Auditions':
                    $_SESSION['Search_Character_ID'] = $_POST['Search_Character_ID'];
                    break;
            }



            $Character_Select = $CharacterGuide->Get_Character_Selector($_SESSION['Project_ID']);
            $Search_Character_Select = $CharacterGuide->Get_Search_Character_Selector($_SESSION['Project_ID']);

            //Front end to Edit or Delete a blog entry.
            $Template = "
            <div class='BlogWrapper'>
            <form action='?view=audition_admin' method='post'>
                <table>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <div class='BlogCreation'>Audition ID [:ID]</div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Audio File:
                        </td>
                        <td>
                            :Audio_File
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Video File:
                        </td>
                        <td>
                            :Video_File
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Notes:
                        </td>
                        <td>
                            <input name='Notes' style='width:100%' type='text' value=':Notes'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Character:
                        </td>
                        <td>
                            :Character_Select
                        </td>
                    </tr>
                    <tr>
                        <td>
                        <input type='submit' size='10' value='Edit' name='Mode'> <input size='10' style='color:red;' type='submit' value='Delete' name='Mode'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name='ID' type='hidden' value=':ID'>
                        </td>
                    </tr>
                </table>
            </form>
            </div>
            ";

            //New Blog Entry, we only show this on page 1.
                echo "
                <div class='ContentHeader'>Add a new Audition.</div><hr>
                <div class='BorderBox'>
                <form action='?view=audition_admin' method='post' enctype='multipart/form-data'>
                    <table>
                    <tr>
                        <td>
                            Audio File:
                        </td>
                        <td>
                            <input name='Audio_File' style='width:100%' type='file'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Video File:
                        </td>
                        <td>
                            <input name='Video_File' style='width:100%' type='file'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Notes:
                        </td>
                        <td>
                            <input name='Notes' style='width:100%' type='text'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Character:
                        </td>
                        <td>
                            {$Character_Select}
                        </td>
                    </tr>
                        <tr>
                            <td>
                                <input size='10' type='submit' value='Add' name='Mode'>
                            </td>
                        </tr>
                    </table>
                </form>
                </div>
                <br>
                <br>
                ";

            echo "<div class='ContentHeader'>Edit an existing Audition.</div><hr>";

            $All_Characters = $CharacterGuide->Get_All_Characters_For_Project($_SESSION['Project_ID']);

            if ($All_Characters) {
                echo "<form action='?view=audition_admin' method='post'>";
                echo $Search_Character_Select;
                echo "<br>";
                echo "<input size='10' type='submit' value='Search Auditions' name='Mode'>";
                echo "</form>";
            }

            echo "<div class='BorderBox'>";

            if ($_SESSION['Project_ID'] && $_SESSION['Search_Character_ID']) {
                if ($_SESSION['Search_Character_ID'] > 0 && $_SESSION['Search_Character_ID'] != "ALL") {
                    $All_Auditions = $CharacterGuide->Get_All_Auditions_For_Character($_SESSION['Search_Character_ID']);
                }

                if ($_SESSION['Search_Character_ID'] == "ALL" || !isset($_SESSION['Search_Character_ID'])) {
                    $All_Auditions = $CharacterGuide->Get_All_Auditions_For_Project($_SESSION['Project_ID']);

                }

                foreach ($All_Auditions as $Audition) {

                    $Parameters[':ID'] = $Audition['ID'];
                    $Parameters[':Notes'] = $Audition['Notes'];
                    $Parameters[':Audio_File'] = $Audition['Audio_File'];
                    $Parameters[':Video_File'] = $Audition['Video_File'];
                    $Parameters[':Character_ID'] = $Audition['Character_ID'];
                    $Audition_Character_Select = $CharacterGuide->Get_Audition_Character_Selector($_SESSION['Project_ID'], $Audition['ID']);

                    $Parameters[':Character_Select'] = $Audition_Character_Select;

                    $CharacterGuide->Display_Templated_Object($Parameters, $Template);
                }
            }

            echo "</div>";
            echo "<br>";
        } else {
            echo "<center>You need to <a href='?view=character_admin'>create a character</a> first.</center>";
        }
    } else {
        echo "<center>You need to <a href='?view=project_admin'>create a project</a> first.</center>";
    }
