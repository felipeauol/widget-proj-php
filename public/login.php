<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/session.php")?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/validation_functions.php")?>

<?php
if(isset($_POST['submit'])) {
    $username = mysqli_prep($_POST['username']);
    $password = $_POST['password'];

    $login_admin = attempt_login($username,$password);

    if($login_admin){
        $_SESSION['admin_id'] = $login_admin['id'];
        $_SESSION['admin_username'] = $login_admin['username'];
        redirect_to('admin.php');
    }else{
        $_SESSION['message'] = "Username/password not found";
    }
}
?>
    <div id="main" xmlns="http://www.w3.org/1999/html">
        <div id="navigation">
        </div>
        <div id="page">
            <h2>Login</h2>
            <div class="message">
            <?php if(isset($_SESSION['message'])){echo $_SESSION['message'];}?>
            </div>
            <div id="form">

                <form action= "login.php" method="post">
                    <p>Username:
                        <input name="username" value="">
                    </p>
                    <p>Password:&nbsp;
                        <input type="password" name="password" value="">
                    </p>
                    <input type="submit" name="submit" value="Login">
                </form>
            </div>
            <br/>
        </div>
    </div>
<?php include("../includes/layouts/footer.html")?>