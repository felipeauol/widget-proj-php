<?php $layout_context = "admin";?>
<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/session.php")?>
<?php confirm_logged_in()?>

<div id="navigation">

</div>
<div id="page">
    <h2>Administrator Dashboard</h2>
    <ul>
        <li><a href="manage_contents.php">Manage Website Content</a></li>
        <li><a href="manage_admins.php">Manage Admin Users</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>
<?php include("../includes/layouts/footer.html")?>
<?php include("../includes/close_dbconnection.php")?>