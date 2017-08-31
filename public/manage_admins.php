<?php require_once("../includes/session.php")?>
<?php $layout_context = "admin";?>
<?php include("../includes/layouts/header.php") ?>
<?php require_once("../includes/functions.php")?>

<?php $all_admins = find_all_admins();?>
<div id="navigation">
</div>

<div id="page">
    <h2>Manage Admins</h2>
        <?php message()?>
        <table>
            <tr>
                <th>Username</th>
                <th>Actions</th>
            </tr>
        <?php while($admin = mysqli_fetch_assoc($all_admins)){
            $output  = "<tr>";
            $output .= "<td>{$admin['username']}</td>";
            $output .= "<td><a href=\"edit_admin.php?id={$admin['id']}\">Edit</a>&nbsp;<a href=\"delete_admin.php?id={$admin['id']}\" onclick=\"return confirm('Are you sure?')\">Delete</a></td>";
            $output .= "<td></td>";
            $output .= "<tr>";
            echo "$output";
        }?>
        </table>
    <br/>
    <a href="create_admin.php"> Create Admin </a>
</div>

<?php include("../includes/layouts/footer.html")?>
<?php include("../includes/close_dbconnection.php")?>