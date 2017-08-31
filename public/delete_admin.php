<?php require_once("../includes/session.php")?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/dbconnect.php")?>

<?php $admin = find_admin_by_id($_GET['id']); ?>

<?php

$query  = "DELETE FROM admins ";
$query .= "WHERE id = {$admin['id']} ";
$query .= "LIMIT 1";

$result = mysqli_query($connection,$query);
confirm_query($result);

if(mysqli_affected_rows($connection) === 1){
    $_SESSION["message"] = "Admin Deleted";
    redirect_to("manage_admins.php");
} else $_SESSION["message"] = "Deletion failed"; redirect_to("manage_admins.php");


