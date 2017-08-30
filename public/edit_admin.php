<?php require_once("../includes/session.php")?>
<?php $layout_context = "admin"?>
<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/validation_functions.php")?>

<?php find_selected_admin();
    if(isset($selected_admin)){
        $current_admin = find_admin_by_id($selected_admin);
    }
?>

<?php
    if(isset($_POST['submit'])){
        $username = mysqli_prep($_POST['username']);
        $password = mysqli_prep($_POST['password']);

        $query =  "UPDATE admins ";
        $query .= "SET username = '{$username}', hashed_password = '{$password}' ";
        $query .= "WHERE id = $selected_admin ";
        $query .= "LIMIT 1";
        $query .= ";";

        $result = mysqli_query($connection, $query);
        confirm_query($result);

        if(mysqli_affected_rows($connection) === 1){
              $_SESSION["message"] = "Admin Updated";
              redirect_to("manage_admins.php");
        }else $message = "Update Failed";
    }
?>


<div id="main" xmlns="http://www.w3.org/1999/html">
    <div id="navigation">
        <h2>Edit Admins</h2>
        <a href="create_admin.php">Create Admin</a>
        <a href="manage_admins.php">Manage Admins</a>
    </div>
    <div id="page">
        <?php if(isset($message)){echo $message;}?>
        <div id="form">

            <form action= "edit_admin.php<?php
            if(isset($selected_admin)){
                echo "?id=$selected_admin";}?>" method="post">
            <p>Username:
                <input name="username" value="<?php if(isset($selected_admin)){echo "{$current_admin['username']}";}?>">
            </p>
            <p>Password:
                <input type="password" name="password" value="">
            </p>
            <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </div>
</div>


<?php include("../includes/layouts/footer.html")?>