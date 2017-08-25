<?php require_once("../includes/session.php")?>
<?php include("../includes/layouts/header.html")?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/validation_functions.php")?>


<?php

if(isset($_POST['submit'])) {

    $menu_name = mysqli_prep($_POST['menu_name']);
    $parent_subject_id = mysqli_prep($_POST['parent_subject']);
    $content = mysqli_prep($_POST['content']);
    $visible = $_POST['visible'];

    $page_count = mysqli_num_rows(find_pages_for_subject($parent_subject_id));
    $new_position = $page_count +1;

    $query = "INSERT INTO pages ";
    $query .= "(menu_name, subject_id, visible, content, position) ";
    $query .= "VALUES ('{$menu_name}',{$parent_subject_id}, {$visible},'{$content}', $new_position)";
    $query .= ";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);


    $required_fields = array("menu_name", "parent_subject", "visible");
    validate_presences($required_fields);

    $fields_with_max_length = array('menu_name' => 30);
    validate_max_lengths($fields_with_max_length);

    if (!empty($errors)){
        $_SESSION['errors'] = $errors;
        redirect_to("new_page.php");
    }

    if ($result) {
        $_SESSION['message'] = "Page created.";
        redirect_to("manage_contents.php");
    } else {
        $_SESSION['message'] = "Subject creation failed.";
        redirect_to("new_page.php");
    } $_SESSION['message'] = "Form submission not detected.";
    redirect_to("new_page.php");
}
?>

<?php find_selected_page() ?>
<div id="main">
<div id="navigation">
    <?php
    echo navigation($selected_subject_id,$selected_page_id);
    ?>
</div>
    <div id="page">
        <div id="form">
            <h2>Create a Page</h2>
                <?php echo message()?>

                <?php
                if (isset($_SESSION['errors'])){
                    echo "<ul>";
                    echo form_errors($_SESSION['errors']);
                    echo "</ul>";
                }; ?>
            </div>

            <form action="new_page.php" method="post">
                <p>Menu name:
                    <input type="text" name="menu_name" value="" />
                </p>
                <p>Select Parent Subject:
                    <select name="parent_subject">
                        <?php
                        $subjects = find_all_subjects();
                        while($subject_row = mysqli_fetch_assoc($subjects)) {
                            echo "<option value=\"{$subject_row['id']}\">{$subject_row['menu_name']}</option>";
                        }
                        ?>
                    </select>
                </p>
<!--                --><?php
//                //TODO: Find a way to update selectable position based on selected subject_name
//                <p>Position:
//                        $page_count = mysqli_num_rows(find_pages_for_subject($selected_page_id));
//                        for($count=1; $count <= ($subject_count + 1); $count++) {
//                            echo "<option value=\"{$count}\">{$count}</option>";
//                        }
//                        ?>
<!--                    </select>-->
<!--                </p>-->
                <p>Visible:
                    <input type="radio" name="visible" value="0" /> No
                    &nbsp;
                    <input type="radio" name="visible" value="1" /> Yes
                </p>
                <p>Content:</br>
                <textarea rows="12" cols="120" name="content"> <?php if( isset($selected_page_id)) {echo htmlentities($page['content']);} ?></textarea>
                </p>
                <input type="submit" name="submit" value="Create Subject" />
            </form>
            <br />
            <a href="manage_contents.php">Cancel</a>

        </div>
    </div>
<?php include("../includes/layouts/footer.html")?>
<?php mysqli_close($connection); ?>