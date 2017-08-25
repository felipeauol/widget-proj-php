<?php require_once("../includes/session.php")?>
<?php include("../includes/layouts/header.html")?>
<?php require_once("../includes/functions.php")?>
<?php require_once("../includes/validation_functions.php")?>

<?php find_selected_page();?>

<?php
if (!$selected_page_id) {
//subject ID was missing or invalid or
//subject couldn't be found in database
redirect_to("manage_contents.php");
}
?>

<?php if(isset($_POST['submit'])) {

// Find position of page being edited
    $current_page = find_page_by_id($selected_page_id);
    $old_position = $current_page['position'];


    $required_fields = array("menu_name", "position", "visible", "content");
    validate_presences($required_fields);

    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_lengths($fields_with_max_lengths);

    if (empty($errors)) {

        $menu_name = $_POST['menu_name'];
        $new_position = (int)$_POST['position'];
        $visible = (int)$_POST['visible'];
        $content = (string)$_POST['content'];
        $safe_content = mysqli_real_escape_string($connection,$content);

        // Look up page within subject that currently holds the new position
        $page_set = find_pages_for_subject($current_page['subject_id']);
        while ($subject_row = mysqli_fetch_assoc($page_set)) {
            if($subject_row['position'] == $new_position){
                $swap_page = $subject_row;
            }
        }

        $query = "UPDATE pages ";
        $query .= "SET menu_name = '{$menu_name}', position = {$new_position}, visible = {$visible}, content = '{$safe_content}'";
        $query .= "WHERE id = {$selected_page_id} ";
        $query .= "LIMIT 1";
        $query .= ";";
        $result = mysqli_query($connection, $query);
        confirm_query($result);


        if ($result && mysqli_affected_rows($connection) == 1) {
            // Success
            $query  = "UPDATE pages ";
            $query .= "SET position = {$old_position} ";
            $query .= "WHERE id = {$swap_page['id']} ";
            $query .= "LIMIT 1";
            $query .= ";";
            $result = mysqli_query($connection, $query);

            $_SESSION["message"] = "Page updated.";
            redirect_to("manage_contents.php");
        } else $message = "Page update Failed";
    }
}
?>

    <div id="main" xmlns="http://www.w3.org/1999/html">
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
            <?php if(isset($selected_page_id)){
                $page = find_page_by_id($selected_page_id);
                echo htmlentities($page['menu_name']);
            }?>
            </h2>

            <?php if(isset($output)){
                echo htmlentities($output);
            }?>

        </div>

        <form action="edit_page.php? <?php
        if(isset($selected_page_id)){
            echo "page={$selected_page_id}";}
        ?>
         " method="post">
            <p>Menu name:
                <input type="text" name="menu_name" value="<?php if(isset($selected_page_id)) {echo htmlspecialchars($page['menu_name']);}?>"/>
            </p>
            <p>Position:
                <select name="position">
                    <?php
                    $page_count = mysqli_num_rows(find_pages_for_subject($page['subject_id']));
                    for($count=1; $count <= ($page_count); $count++) {
                        echo "<option value=\"{$count}\" ";
                            if( isset($selected_page_id) && $count == $page['position']) {
                                echo "selected";
                            }
                        echo ">{$count}</option>";
                    }
                    ?>
                </select>
            </p>
            <p>Visible:
                <input type="radio" name="visible" value="0" <?php if( isset($selected_page_id) && $page['visible'] == 0) {echo "checked=checked";} ?> /> No
                &nbsp;
                <input type="radio" name="visible" value="1" <?php if( isset($selected_page_id) && $page['visible'] == 1) {echo "checked=checked";} ?> /> Yes
            </p>
            <p>Content:</br>
                <textarea rows="12" cols="120" name="content"> <?php if( isset($selected_page_id)) {echo htmlentities($page['content']);} ?></textarea>
            </p>
            <input type="submit" name="submit" value="Save" />

        </form>
        <br />
        <a href="manage_contents.php">Cancel</a>
        &nbsp;
        &nbsp;
        <a href="delete_page.php?page=<?php echo urlencode($selected_page_id)?>" onclick="return confirm('Are you sure?')">Delete</a>
        </div>

    </div>

<?php include("../includes/layouts/footer.html")?>
<?php mysqli_close($connection); ?>