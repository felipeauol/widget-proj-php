<?php require_once("../includes/session.php")?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/dbconnect.php")?>

<?php $subject = find_subject_by_id($_GET['subject']); ?>

<?php

if(!$subject){
    redirect_to("manage_contents.php");
}

$pages_on_subject = find_pages_for_subject($subject['id'],false);
if(mysqli_num_rows($pages_on_subject) > 0 ){
    $_SESSION['message'] = "Cannot delete subject with pages";
    redirect_to("edit_subject?subject={$subject['id']}");
}

$query = "DELETE FROM subjects ";
$query .= "WHERE id = {$subject['id']} ";
$query .= "LIMIT 1;";

$result = mysqli_query($connection,$query);
confirm_query($result);

if($result && mysqli_affected_rows($connection) == 1) {
    $_SESSION['message'] = "Subject Deleted";
    redirect_to("manage_contents.php");
}   else {
    $_SESSION['message'] = "Deletion Failed";
    redirect_to("edit_subject?subject={$subject['id']}");
}
?>