<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/session.php")?>
<?php

$_SESSION['username'] = null;
$_SESSION['admin_id'] = null;
redirect_to('login.php');
