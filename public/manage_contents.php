<?php include("../includes/layouts/header.html")?>
<?php require_once("../includes/functions.php")?>

<?php
if(isset($_GET["subject"])){
    $selected_subject_id = $_GET["subject"];
    $selected_page_id = null;
    }elseif (isset($_GET["page"])){
        $selected_page_id = $_GET["page"];
        $selected_subject_id = null;
    }else {
        $selected_subject_id = null;
        $selected_page_id = null;
    }
?>
<div id="main">
<div id="navigation">
    <?php
    echo navigation($selected_subject_id,$selected_page_id);
?>
</div>
        <div id="page">
            <h2>Manage Content</h2>
                <?php echo "pageid" . $selected_page_id; ?> <br />
                <?php echo "subjectid" . $selected_subject_id; ?>
        </div>
</div>
<?php include("../includes/layouts/footer.html")?>

<?php mysqli_close($connection); ?>