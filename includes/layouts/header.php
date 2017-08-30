<?php
	define("DB_SERVER", "localhost");
	define("DB_USER", "widget_ceo");
	define("DB_PASS", "hakunapotato");
	define("DB_NAME", "widget_corp");

  // 1. Create a database connection
  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " .
         mysqli_connect_error() .
         " (" . mysqli_connect_errno() . ")"
    );
  }
?>

<?php
    if(!isset($layout_context)){
        $layout_context = "public";
    }
?>
<!doctype HTML>

<html lang="en">
<head>
    <title>Widget Inc. <?php if($layout_context == "admin"){ echo " - Administrator Dashboard";}?></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <link href="./css/public.css" media="all" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="header">
    <h1>Widget Inc<?php if($layout_context == "admin"){ echo " - Administrator Dashboard";}?></h1>
</div>