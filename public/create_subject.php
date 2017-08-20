<?php require_once("../includes/session.php")?>
<?php include("../includes/layouts/header.html")?>
<?php require_once("../includes/functions.php")?>

<?php

if(isset($_POST['submit'])) {

    $menu_name = mysqli_prep($_POST['menu_name']);
    $position = (int)$_POST['position'];
    $visible = (int)$_POST['visible'];

    $query = "INSERT INTO subjects ";
    $query .= "(menu_name, position, visible) ";
    $query .= "VALUES ('{$menu_name}', '{$position}', '{$visible}') ";
    $query .= ";";
    $result = mysqli_query($connection, $query);


    if ($result) {
        $_SESSION['message'] = "Subject created.";
        redirect_to("manage_contents.php");
    } else {
        $_SESSION['message'] = "Subject creation failed.";
        redirect_to("new_subject.php");
    }
    } else $_SESSION['message'] = "Form submission not detected.";
        redirect_to("new_subject.php");