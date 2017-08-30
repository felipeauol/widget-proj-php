<?php require_once("../includes/session.php")?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/dbconnect.php")?>

<?php $page = find_page_by_id($_GET['page']); ?>

<?php

if(!$page){
    redirect_to("manage_contents.php");
}

$query = "DELETE FROM pages ";
$query .= "WHERE id = {$page['id']} ";
$query .= "LIMIT 1;";

$result = mysqli_query($connection,$query);
confirm_query($result);

if($result && mysqli_affected_rows($connection) == 1) {
    $_SESSION['message'] = "Page Deleted";
    redirect_to("manage_contents.php");
}   else {
    $_SESSION['message'] = "Deletion Failed";
    redirect_to("edit_subject?subject={$page['id']}");
}

?>