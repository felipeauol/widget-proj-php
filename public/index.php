<?php $layout_context = "public";?>
<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/functions.php")?>

<?php find_selected_page(true) ?>

<div id="main">
<div id="navigation">
    <?php echo public_navigation($selected_subject_id,$selected_page_id); ?>
</div>
    <div id="page">
    <h2><?php  if(isset($selected_page_id)){
                    $current_page = find_page_by_id($selected_page_id);
                    echo htmlentities($current_page['menu_name']);
                }
        ?></h2>
        <?php
            if(isset($selected_page_id)){
                $current_page = find_page_by_id($selected_page_id);
        ?>
            <div>
                <?php if(isset($selected_page_id)){
                    echo nl2br(htmlentities($current_page['content']));}?>
            </div>
                <?php
            }else{
                echo "Welcome!";
            } ?>
    </div>
</div>
<?php include("../includes/layouts/footer.html")?>

<?php mysqli_close($connection); ?>