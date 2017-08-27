<?php $layout_context = "public";?>
<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/functions.php")?>

<?php find_selected_page() ?>

<div id="main">
<div id="navigation">
    <?php echo public_navigation($selected_subject_id,$selected_page_id); ?>
</div>
    <div id="page">
    <h2>View Content</h2>
        <?php
            if(isset($selected_subject_id)){
                $current_subject = find_subject_by_id($selected_subject_id);
                echo "Subject: " . htmlentities($current_subject['menu_name']);
            }
            elseif(isset($selected_page_id)){
                $current_page = find_page_by_id($selected_page_id);
                echo htmlentities($current_page['menu_name']);
        ?>
            <div class="view-content">
                <?php echo htmlentities($current_page['content']);?>
            </div>
                <?php
            }else{
                echo "Please select a page";
            } ?>
    </div>
</div>
<?php include("../includes/layouts/footer.html")?>

<?php mysqli_close($connection); ?>