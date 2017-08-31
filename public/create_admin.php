<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/session.php")?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/validation_functions.php")?>

<?php
if(isset($_POST['submit'])) {
    $username = mysqli_prep($_POST['username']);
    $hashed_password = password_encrypt($_POST['password']);

    $query = "INSERT INTO admins ";
    $query .= "(username, hashed_password) ";
    $query .= "VALUES ('$username', '$hashed_password')";
    $query .= ";";

    $result = mysqli_query($connection, $query);
    confirm_query($result);

    $required_fields = array("username", "password");
        validate_presences($required_fields);
}
?>


<div id="main" xmlns="http://www.w3.org/1999/html">
    <div id="navigation">
    </div>
    <div id="page">
        <h2>Create Admin</h2>
        <?php if(isset($message)){echo $message;}?>
        <div id="form">

            <form action= "create_admin.php<?php
            if(isset($selected_admin)){
                echo "?id=$selected_admin";}?>" method="post">
                <p>Username:
                    <input name="username" value="">
                </p>
                <p>Password:&nbsp;
                    <input type="password" name="password" value="">
                </p>
                <input type="submit" name="submit" value="Create Admin">
            </form>
        </div>
        <br/>
        <a href="manage_admins.php">Cancel</a>
    </div>
</div>

<?php include("../includes/layouts/footer.html")?>