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

<?php
if(isset($_POST['submit'])) {

    $menu_name = mysqli_prep($_POST['menu_name']);
    $position = (int)$_POST['position'];
    $visible = (int)$_POST['visible'];


    $query = "UPDATE subjects ";
    $query .= "SET menu_name = '{$menu_name}', position = {$position}, visible = {$visible} ";
    $query .= "WHERE id = {$selected_subject_id} ";
    $query .= ";";
    $result = mysqli_query($connection, $query);
    confirm_query($result);

}
?>


    <div id="main">
        <div id="navigation">
            <?php
            echo navigation($selected_subject_id,$selected_page_id);
            ?>
        </div>

        <div id="form">
            <h2>Edit Subject:
            <?php if(isset($selected_subject_id)){
                $subject = find_subject_by_id($selected_subject_id);
                echo $subject['menu_name'];
            }?>
            </h2>
            <?php echo message()?>

            <?php
            if (isset($_SESSION['errors'])){
                echo "<ul>";
                echo form_errors($_SESSION['errors']);
                echo "</ul>";
            }; ?>
        </div>

        <form action="edit_subject.php? <?php
        if(isset($selected_subject_id)){
            echo "subject={$selected_subject_id}";}
        ?>
         " method="post">
            <p>Menu name:
                <input type="text" name="menu_name" value="<?php
                if(isset($selected_subject_id)) {
                    $subject = find_subject_by_id($selected_subject_id);
                    echo $subject['menu_name'];
                }
                ?>
                "/>
            </p>
            <p>Position:
                <select name="position">
                    <?php
                    $subject_count = mysqli_num_rows(find_all_subjects());
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
                <input type="radio" name="visible" value="0"/> No
                &nbsp;
                <input type="radio" name="visible" value="1" <?php
                    if( isset($selected_subject_id) && $subject['visible'] == 1) {
                        echo "checked=checked";
                    }
                    ?>
                /> Yes
            </p>
            <input type="submit" name="submit" value="Save" />
        </form>
        <br />
        <a href="manage_contents.php">Cancel</a>
        <br/>

    </div>
<?php include("../includes/layouts/footer.html")?>

<?php mysqli_close($connection); ?>