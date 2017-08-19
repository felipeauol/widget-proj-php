<?php include("../includes/layouts/header.html")?>
<?php require_once("../includes/functions.php")?>


<div id="navigation" class="subjects">
    <ul class="subjects">
                <?php
                    $subject_set = find_all_subjects();
                ?>

                <?php
                    while($subject_row = mysqli_fetch_assoc($subject_set)) {
                ?>

            <li>    <?php echo $subject_row['menu_name'] ?>

                    <?php
                    $page_set = find_pages_for_subject($subject_row['id']);
                    ?>

                <ul class="pages">
                <?php while($page_row = mysqli_fetch_assoc($page_set)) {?>

                        <li><?php echo $page_row['menu_name'];} ?></li>
                </ul>

            </li>
        <?php
            }
        ?>
        </div>
    </ul>
        <div id="page">
            <h2>Manage Content</h2>

            <main>

            </main>
        </div>

<?php include("../includes/layouts/footer.html")?>

<?php mysqli_close($connection); ?>