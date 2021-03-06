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

        echo $CharacterGuide->Get_Global_Project_Selector($_SESSION['ID']);

        //Logic to perform based on post data.
        $String_Protector_Array = array("<script","</script>","<source","<audio","('","')", "window.location", "onerror=");
        switch ($_POST['Mode'])
        {
            case 'Edit':
                $CharacterGuide = new CharacterGuide();
                $Passed_Parameters['Title'] = str_replace($String_Protector_Array,"",$_POST['Title']);
                $Passed_Parameters['Project_ID'] = str_replace($String_Protector_Array,"",$_POST['Project_ID']);
                $CharacterGuide->Edit_Scene($_POST['ID'], $Passed_Parameters);
                break;

            case 'Add':
                $CharacterGuide = new CharacterGuide();
                $Passed_Parameters['Title'] = str_replace($String_Protector_Array,"",$_POST['Title']);
                $Passed_Parameters['Project_ID'] = str_replace($String_Protector_Array,"",$_POST['Project_ID']);
                $Passed_Parameters['Owner_ID'] = $_SESSION['ID'];
                $CharacterGuide->Create_Scene($Passed_Parameters);
                break;

            case 'Delete':
                $CharacterGuide = new CharacterGuide();
                $CharacterGuide->Delete_Scene($_POST['ID']);
                break;
        }


        $Project_Select = $CharacterGuide->Get_Project_Selector($_SESSION['ID']);

        //Front end to Edit or Delete a blog entry.
        $Template = "
        <div class='BlogWrapper'>
        <form action='?view=scene_admin' method='post'>
            <table>
                <tr>
                    <td>
                    </td>
                    <td>
                        <div class='BlogCreation'>Scene ID [:ID] - :Title</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        Title:
                    </td>
                    <td>
                        <input name='Title' style='width:100%' type='text' value=':Title'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Project:
                    </td>
                    <td>
                        :Project_Select
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
            <div class='ContentHeader'>Add a new Scene.</div><hr>
            <div class='BorderBox'>
            <form action='?view=scene_admin' method='post'>
                <table>
                    <tr>
                        <td>
                            Title:
                        </td>
                        <td>
                            <input name='Title' style='width:100%' type='text'>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Project:
                        </td>
                        <td>
                        {$Project_Select}
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

        echo "<div class='ContentHeader'>Edit an existing Scene.</div><hr>";

        if ($All_Projects) {
            echo "<form action='?view=scene_admin' method='post'>";
            echo $Project_Select;
            echo "<br>";
            echo "<input size='10' type='submit' value='Search Scenes' name='Mode'>";
            echo "</form>";
        }

        echo "<div class='BorderBox'>";

        if ($_SESSION['Project_ID']) {
            $All_Scenes = $CharacterGuide->Get_All_Scenes_In_Project($_SESSION['Project_ID']);
            foreach ($All_Scenes as $Scene) {

                $Parameters[':ID'] = $Scene['ID'];
                $Parameters[':Title'] = $Scene['Title'];
                $Parameters[':Project_Select'] = $Project_Select;

                $CharacterGuide->Display_Templated_Object($Parameters, $Template);
            }
        }

        echo "</div>";
        echo "<br>";
    } else {
        echo "<center>You need to <a href='?view=project_admin'>create a project</a> first.</center>";
    }