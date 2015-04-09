<?php

    Functions::Check_User_Permissions_Redirect("User");
    $User = new User($_SESSION['ID']);

    //Logic to perform based on post data.
    $String_Protector_Array = array("<script","</script>","<source","<audio","('","')", "window.location", "onerror=");
    switch ($_POST['Mode'])
    {
        case 'Edit':
            $CharacterGuide = new CharacterGuide();
            $Passed_Parameters['Title'] = str_replace($String_Protector_Array,"",$_POST['Title']);
            $Passed_Parameters['Type'] = str_replace($String_Protector_Array,"",$_POST['Type']);
            $CharacterGuide->Edit_Project($_POST['ID'], $Passed_Parameters);
            break;

        case 'Add':
            $CharacterGuide = new CharacterGuide();
            $Passed_Parameters['Title'] = str_replace($String_Protector_Array,"",$_POST['Title']);
            $Passed_Parameters['Type'] = str_replace($String_Protector_Array,"",$_POST['Type']);
            $CharacterGuide->Create_Project($Passed_Parameters);
            break;

        case 'Delete':
            $CharacterGuide = new CharacterGuide();
            $CharacterGuide->Delete_Project($_POST['ID']);
            break;
    }

    //Build Blog data and page for editing.
    $CharacterGuide = new CharacterGuide();

    //Front end to Edit or Delete a blog entry.
    $Template = "
    <div class='BlogWrapper'>
    <form action='?view=project_admin' method='post'>
        <table>
            <tr>
                <td>
                </td>
                <td>
                    <div class='BlogCreation'>Project ID [:ID] - :Title - Owned by :Username</div>
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
                    Type:
                </td>
                <td>
                    <select name='Type'>
                      <option :DirectorSelected value='Director'>Director</option>
                      <option :UserSelected value='User'>User</option>
                    </select>
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
        <div class='ContentHeader'>Add a new Project.</div><hr>
        <div class='BorderBox'>
        <form action='?view=project_admin' method='post'>
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
                        Type:
                    </td>
                    <td>
                        <select name='Type'>
                          <option value='Director'>Director</option>
                          <option value='User'>User</option>
                        </select>
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

    echo "<div class='ContentHeader'>Edit an existing Project.</div><hr>";
    echo "<div class='BorderBox'>";

    $All_Projects = $CharacterGuide->Get_All_Projects_For_User($_SESSION['ID']);
    foreach ($All_Projects as $Project) {
        $User = new User($Project['Owner_ID']);

        $Parameters[':ID'] = $Project['ID'];
        $Parameters[':Title'] = $Project['Title'];
        $Parameters[':Type'] = $Project['Type'];
        if ($Project['Type'] == 'Director') {
            $Parameters[':DirectorSelected'] = " selected ";
            $Parameters[':UserSelected'] = "";
        } else {
            $Parameters[':DirectorSelected'] = "";
            $Parameters[':UserSelected'] = " selected ";
        }
        $Parameters[':Username'] = $User->Username;

        $CharacterGuide->Display_Templated_Object($Parameters, $Template);
    }

    echo "</div>";
    echo "<br>";