<?php require_once("../includes/session.php")?>
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

            <?php echo message(); ?>

                <?php
                if(isset($selected_subject_id)){
                    $current_subject = find_subject_by_id($selected_subject_id);
                    echo "Subject: " . htmlentities($current_subject['menu_name']);
                    echo "<br />";
                    echo "Position: " . htmlentities($current_subject['position']);
                    echo "<br />";
                    echo "Visible: " . htmlentities($current_subject['visible']);
                    echo "<br />";
                    echo "<a href=\"edit_subject.php?subject=$selected_subject_id\">Edit Subject</a>";
                }
                elseif(isset($selected_page_id)){
                    $current_page = find_page_by_id($selected_page_id);
                    echo htmlentities($current_page['menu_name']);
                    echo "<br />";
                    echo "Position: " . htmlentities($current_page['position']);
                    echo "<br />";
                    echo "Visible: " . htmlentities($current_page['visible']);
                    echo "<br />";
                    echo "Content: ";
                    echo "<br />";
                    echo "<br />";
                    ?>
                    <div class="view-content">
                   <?php echo htmlentities($current_page['content']);?>
                   </div>
                    <?php
                    echo "<a href=\"edit_page.php?page=$selected_page_id\">Edit Page</a>";
                }else{
                    echo "Please select a page";
                } ?>


        </div>
</div>
<?php include("../includes/layouts/footer.html")?>

<?php mysqli_close($connection); ?>