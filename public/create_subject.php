<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/session.php")?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/validation_functions.php")?>
<?php confirm_logged_in()?>

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

    $required_fields = array("menu_name", "position", "visible");
    validate_presences($required_fields);

    $fields_with_max_length = array('menu_name' => 30);
    validate_max_lengths($fields_with_max_length);

    if (!empty($errors)){
        $_SESSION['errors'] = $errors;
        redirect_to("new_subject.php");
    }

    if ($result) {
        $_SESSION['message'] = "Subject created.";
        redirect_to("manage_contents.php");
        } else {
            $_SESSION['message'] = "Subject creation failed.";
            redirect_to("new_subject.php");
        } $_SESSION['message'] = "Form submission not detected.";
        redirect_to("new_subject.php");
}