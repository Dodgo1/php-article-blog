<?php
require_once("header.php");
require_once ("functions.php");
require_once "conn.php";

if (isset($_POST['action'])) {
    switch($_POST['action']){
        case 'status':
            set_user_status($conn,$_POST['id'],$_POST['status']);
        case 'delete':
            delete_user($conn,$_POST['id']);
    }
}

$users = get_users($conn);
?>

<div class="user_table">
<?php
foreach ($users as $user){
    $name = $user["userName"];
    $id = $user["userId"];
    $status = $user["userStatus"];
    $folder = $user["userFolder"];
    $articles = $user["userArticlesIDs"];

    echo '<div class="user">';
    echo "
            <p>$name</p>
            <p>$id</p>
            <p>$status</p>
            <p>$folder</p>
            <p>$articles</p>
            <form method='POST' action='admin.php'>
                <input type='hidden' name='action' value='status'>
                <input type='hidden' name='status' value='ACTIVE'>
                <input type='hidden' name='id' value='$id'>
                    <input type='submit' value='APPROVE'/>
              </form>
            <form method='POST' action='admin.php'>
                <input type='hidden' name='action' value='delete'>
                <input type='hidden' name='id' value='$id'>
                    <input type='submit' value='DELETE'/>
            </form>
         ";
    echo '</div>';
}
?>
</div>


<?php
// pin articles to right column
// approve articles





