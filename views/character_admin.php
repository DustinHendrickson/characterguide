<?php

    Functions::Check_User_Permissions_Redirect("User");
    $User = new User($_SESSION['ID']);

    //Logic to perform based on post data.
    $String_Protector_Array = array("<script","</script>","<source","<audio","('","')", "window.location", "onerror=");
    switch ($_POST['Mode'])
    {
        case 'Edit':
            $CharacterGuide = new CharacterGuide();
            foreach($_POST['In_Scenes'] as $In_Scene) {
                $In_Scenes .= $In_Scene . ",";
            }
            $Passed_Parameters['Name'] = str_replace($String_Protector_Array,"",$_POST['Name']);
            $Passed_Parameters['Description'] = str_replace($String_Protector_Array,"",$_POST['Description']);
            $Passed_Parameters['Gender'] = str_replace($String_Protector_Array,"",$_POST['Gender']);
            $Passed_Parameters['In_Scenes'] = str_replace($String_Protector_Array,"",$In_Scenes);
            $CharacterGuide->Edit_Character($_POST['ID'], $Passed_Parameters);
            break;

        case 'Add':
            $CharacterGuide = new CharacterGuide();
            foreach($_POST['In_Scenes'] as $In_Scene) {
                $In_Scenes .= $In_Scene . ",";
            }
            $Passed_Parameters['Name'] = str_replace($String_Protector_Array,"",$_POST['Name']);
            $Passed_Parameters['Description'] = str_replace($String_Protector_Array,"",$_POST['Description']);
            $Passed_Parameters['Gender'] = str_replace($String_Protector_Array,"",$_POST['Gender']);
            $Passed_Parameters['In_Scenes'] = str_replace($String_Protector_Array,"",$In_Scenes);
            $Passed_Parameters['Owner_ID'] = $_SESSION['ID'];
            $CharacterGuide->Create_Character($Passed_Parameters);
            break;

        case 'Delete':
            $CharacterGuide = new CharacterGuide();
            $CharacterGuide->Delete_Character($_POST['ID']);
            break;
    }

    //Build Blog data and page for editing.
    $CharacterGuide = new CharacterGuide();

    $SearchAll_Scenes = $CharacterGuide->Get_All_Scenes_For_User($_SESSION['ID']);
    $SearchScene_Select .= "<select name='SearchScene_ID'>";
    $SearchScene_Select .= "<option selected value='All'> All Scenes </option>";
    foreach($SearchAll_Scenes as $Scene) {
        $Selected = "";
        if($_POST['SearchScene_ID'] == $Scene['ID']) { $Selected = "selected"; }
        $SearchScene_Select .= "<option {$Selected} value='{$Scene['ID']}'> {$Scene['Title']} </option>";
    }
    $SearchScene_Select .= "</select>";

    $DisplayAll_Scenes = $CharacterGuide->Get_All_Scenes_For_User($_SESSION['ID']);
    $DisplayScene_Select .= "<select multiple name='In_Scenes[]'>";
    foreach($DisplayAll_Scenes as $Scene) {
        $DisplayScene_Select .= "<option value='{$Scene['ID']}'> {$Scene['Title']} </option>";
    }
    $DisplayScene_Select .= "</select>";

    //Front end to Edit or Delete a blog entry.
    $Template = "
    <div class='BlogWrapper'>
    <form action='?view=character_admin' method='post'>
        <table>
            <tr>
                <td>
                </td>
                <td>
                    <div class='BlogCreation'>Character ID [:ID] - :Name</div>
                </td>
            </tr>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input name='Name' style='width:100%' type='text' value=':Name'>
                </td>
            </tr>
            <tr>
                <td>
                    Description:
                </td>
                <td>
                    <input name='Description' style='width:100%' type='text' value=':Description'>
                </td>
            </tr>
            <tr>
                <td>
                    Gender:
                </td>
                <td>
                    <input name='Gender' style='width:100%' type='text' value=':Gender'>
                </td>
            </tr>
            <tr>
                <td>
                    In Scenes:
                </td>
                <td>
                    :Scene_Select
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
        <div class='ContentHeader'>Add a new Character.</div><hr>
        <div class='BorderBox'>
        <form action='?view=character_admin' method='post'>
            <table>
                <tr>
                    <td>
                        Name:
                    </td>
                    <td>
                        <input name='Name' style='width:100%' type='text'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Description:
                    </td>
                    <td>
                        <input name='Description' style='width:100%' type='text'>
                    </td>
                </tr>
                <tr>
                    <td>
                        Gender:
                    </td>
                    <td>
                        <input name='Gender' style='width:100%' type='text'>
                    </td>
                </tr>
                <tr>
                    <td>
                        In Scenes:
                    </td>
                    <td>
                    {$DisplayScene_Select}
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

    echo "<div class='ContentHeader'>Edit an existing Character.</div><hr>";

    if ($SearchAll_Scenes) {
        echo "<form action='?view=character_admin' method='post'>";
        echo $SearchScene_Select;
        echo "<br>";
        echo "<input size='10' type='submit' value='Search Characters' name='Mode'>";
        echo "</form>";
    }

    echo "<div class='BorderBox'>";

    if ($_POST['SearchScene_ID']) {

        if($_POST['SearchScene_ID'] > 0) {
            $All_Characters = $CharacterGuide->Get_All_Characters_In_Scene($_POST['SearchScene_ID']);
        }

        if($_POST['SearchScene_ID'] == "All") {
            $All_Characters = $CharacterGuide->Get_All_Characters_For_User($_SESSION['ID']);
        }

        if ($All_Characters) {
            foreach ($All_Characters as $Character) {

                $Parameters[':ID'] = $Character['ID'];
                $Parameters[':Name'] = $Character['Name'];
                $Parameters[':Description'] = $Character['Description'];
                $Parameters[':Gender'] = $Character['Gender'];

                $All_Scenes = $CharacterGuide->Get_All_Scenes_For_User($_SESSION['ID']);

                $Character_Scenes = $CharacterGuide->Get_All_Scenes_For_Character($Character['ID']);

                $Scene_Select = "";
                $Scene_Select .= "<select multiple name='In_Scenes[]'>";
                foreach($All_Scenes as $Selected_Scene) {
                    $Selected = "";

                    if(in_array($Selected_Scene['ID'], $Character_Scenes)) { $Selected = "selected"; }
                    $Scene_Select .= "<option " . $Selected . " value='" . $Selected_Scene['ID'] ."'> ". $Selected_Scene['Title'] . " </option>";
                }
                $Scene_Select .= "</select>";

                $Parameters[':Scene_Select'] = $Scene_Select;

                $CharacterGuide->Display_Templated_Object($Parameters, $Template);
            }
        } else { echo "No Characters Found in Search."; }
    }

    echo "</div>";
    echo "<br>";