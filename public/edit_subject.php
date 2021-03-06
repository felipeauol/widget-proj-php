<?php require_once("../includes/session.php")?>
<?php $layout_context = "admin"?>
<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/validation_functions.php")?>
<?php confirm_logged_in()?>

<?php find_selected_page();?>

<?php
if (!$selected_subject_id) {
    // subject ID was missing or invalid or
    // subject couldn't be found in database
    redirect_to("manage_contents.php");
}
?>

<?php if(isset($_POST['submit'])) {

    $required_fields = array("menu_name", "position", "visible");
    validate_presences($required_fields);

    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_lengths);

    if (empty($errors)) {

        $menu_name = $_POST['menu_name'];
        $position = (int)$_POST['position'];
        $visible = (int)$_POST['visible'];


        $query = "UPDATE subjects ";
        $query .= "SET menu_name = '{$menu_name}', position = {$position}, visible = {$visible} ";
        $query .= "WHERE id = {$selected_subject_id} ";
        $query .= "LIMIT 1";
        $query .= ";";
        $result = mysqli_query($connection, $query);
        confirm_query($result);

        if ($result && mysqli_affected_rows($connection) == 1) {
            // Success
            $_SESSION["message"] = "Subject updated.";
            redirect_to("manage_contents.php");
        } else $message = "Subject update Failed";
    }
}
?>

    <div id="main">
        <div id="navigation">
            <?php
            echo navigation($selected_subject_id,$selected_page_id);
            ?>
        </div>

        <div id="page">
            <?php if(!empty($message)){
                echo "<div class=\"message\">" . $message . "</div>";
            }?>
            <div id="error">
            <?php if(isset($_POST['submit'])){echo form_errors($errors);} ?>
            </div>
            <?php echo message() ?>

        <div id="form">
            <h2>Edit Subject:
            <?php if(isset($selected_subject_id)){
                $subject = find_subject_by_id($selected_subject_id);
                echo htmlentities($subject['menu_name']);
            }?>
            </h2>

            <?php if(isset($output)){
                echo htmlentities($output);
            }?>

        </div>

        <form action="edit_subject.php? <?php
        if(isset($selected_subject_id)){
            echo "subject={$selected_subject_id}";}
        ?>
         " method="post">
            <p>Menu name:
                <input type="text" name="menu_name" value="<?php if(isset($selected_subject_id)) {echo htmlspecialchars($subject['menu_name']);}?>"/>
            </p>
            <p>Position:
                <select name="position">
                    <?php
                    $subject_count = mysqli_num_rows(find_all_subjects(false));
                    for($count=1; $count <= ($subject_count); $count++) {
                        echo "<option value=\"{$count}\" ";
                            if( isset($selected_subject_id) && $count == $subject['position']) {
                                echo "selected";
                            }
                        echo ">{$count}</option>";
                    }
                    ?>
                </select>
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" <?php if( isset($selected_subject_id) && $subject['visible'] == 0) {echo "checked=checked";} ?> /> No
                &nbsp;
                <input type="radio" name="visible" value="1" <?php if( isset($selected_subject_id) && $subject['visible'] == 1) {echo "checked=checked";} ?> /> Yes
            </p>
            <input type="submit" name="submit" value="Save" />
        </form>
        <br />
        <a href="manage_contents.php">Cancel</a>
        &nbsp;
        &nbsp;
        <a href="delete_subject.php?subject=<?php echo urlencode($selected_subject_id)?>" onclick="return confirm('Are you sure?')">Delete</a>
        </div>

    </div>

<?php include("../includes/layouts/footer.html")?>
<?php mysqli_close($connection); ?>