<?php require_once("../includes/session.php")?>
<?php $layout_context = "admin"?>
<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/functions.php")?>
<?php confirm_logged_in()?>

<?php find_selected_page() ?>

<div id="main">
<div id="navigation">
    <?php
    echo navigation($selected_subject_id,$selected_page_id);
    ?>
</div>
    <div id="page">
        <div id="form">
            <h2>Create a Subject</h2>
                <?php echo message()?>

                <?php
                if (isset($_SESSION['errors'])){
                    echo "<ul>";
                    echo form_errors($_SESSION['errors']);
                    echo "</ul>";
                }; ?>
            </div>

            <form action="create_subject.php" method="post">
                <p>Menu name:
                    <input type="text" name="menu_name" value="" />
                </p>
                <p>Position:
                    <select name="position">
                        <?php
                        $subject_count = mysqli_num_rows(find_all_subjects(false));
                        for($count=1; $count <= ($subject_count + 1); $count++) {
                            echo "<option value=\"{$count}\">{$count}</option>";
                        }
                        ?>
                    </select>
                </p>
                <p>Visible:
                    <input type="radio" name="visible" value="0" /> No
                    &nbsp;
                    <input type="radio" name="visible" value="1" /> Yes
                </p>
                <input type="submit" name="submit" value="Create Subject" />
            </form>
            <br />
            <a href="manage_contents.php">Cancel</a>

        </div>
    </div>
<?php include("../includes/layouts/footer.html")?>
<?php mysqli_close($connection); ?>