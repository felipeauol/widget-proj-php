<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/session.php")?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/validation_functions.php")?>

<?php
if(isset($_POST['submit'])) {
    $username = mysqli_prep($_POST['username']);
    $password = mysqli_prep($_POST['password']);

    $query = "INSERT INTO admins ";
    $query .= "(username, hashed_password) ";
    $query .= "VALUES ('$username', '$password')";
    $query .= ";";

    $result = mysqli_query($connection, $query);
    confirm_query($result);

    $required_fields = array("username", "password");
        validate_presences($required_fields);
}
?>


<div id="main" xmlns="http://www.w3.org/1999/html">
    <div id="navigation">
        <h2>Edit Admins</h2>
        <a href="create_admin.php">Create Admin</a><br/>
        <a href="manage_admins.php">Manage Admins</a>
    </div>
    <div id="page">
        <?php if(isset($message)){echo $message;}?>
        <div id="form">

            <form action= "create_admin.php<?php
            if(isset($selected_admin)){
                echo "?id=$selected_admin";}?>" method="post">
                <p>Username:
                    <input name="username" value="">
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