<?php include("../includes/layouts/header.html")?>
<?php require_once("../includes/functions.php")?>

<?php

if(isset($_GET["subject"])){
    $selected_subject_id = $_GET["subject"];
    $selected_page_id = null;
}elseif (isset($_GET["page"])){
    $selected_page_id = $_GET["page"];
    $selected_subject_id = null;
}else $selected_page_id = null && $selected_page_id = null;

?>
<div id="navigation" class="subjects">
    <ul>
                <?php
                    $subject_set = find_all_subjects();
                ?>

                <?php
                    while($subject_row = mysqli_fetch_assoc($subject_set)) {
                ?>

                <?php
                echo "<li";
                if($selected_subject_id == $subject_row['id']){
                    echo " class=\"selected\"";
                }
                echo ">";
                ?>
                        <a href="manage_contents.php?subject=<?php echo urlencode($subject_row['id'])?>">
                        <?php echo $subject_row['menu_name'] ?>
                    </a>

                    <?php
                    $page_set = find_pages_for_subject($subject_row['id']);
                    ?>

                <ul class="pages">
                    <?php while($page_row = mysqli_fetch_assoc($page_set)) {?>

                    <?php
                    echo "<li";
                    if($selected_page_id == $page_row['id']){
                        echo " class=\"selected\"";
                    }
                    echo ">";
                    ?>
                            <a href="manage_contents.php?page=<?php echo urlencode($page_row['id'])?>">
                            <?php echo $page_row['menu_name'];} ?>
                            </a>
                        </li>

                </ul>

            </li>
        <?php
            }
        ?>
        </div>
    </ul>
        <div id="page">
            <h2>Manage Content</h2>
<!--                --><?php //echo "pageid" . $selected_page_id; ?>
<!--                --><?php //echo "subjectid" . $selected_subject_id; ?><!-- <br />-->
            <main>

            </main>
        </div>

<?php include("../includes/layouts/footer.html")?>

<?php mysqli_close($connection); ?>