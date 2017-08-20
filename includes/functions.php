<?php
    function redirect_to($new_location){
        header("Location: " . $new_location);
        exit;
    }
    function mysqli_prep($string) {
    global $connection;

    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
}
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}
	function find_all_subjects(){
       	global $connection;

        $query  = "SELECT * ";
        $query .= "FROM subjects ";
        $query .= "WHERE visible = 1 ";
        $query .= "ORDER BY position ASC";
        $query .= ";";
        $subject_set = mysqli_query($connection,$query);
        confirm_query($subject_set);

        return $subject_set;
}
	function find_pages_for_subject($subject_id){
		global $connection;

        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE visible = 1 ";
        $query .= "AND subject_id = $subject_id ";
        $query .= "ORDER BY position ASC ";
        $query .= ";";
        $page_set = mysqli_query($connection,$query);
        confirm_query($page_set);

        return $page_set;
	}

	function find_subject_by_id($subject_id){
	    global $connection;

        $safe_id = mysqli_real_escape_string($connection,$subject_id);

        $query  = "SELECT * ";
        $query .= "FROM subjects ";
        $query .= "WHERE id = {$safe_id} ";
        $query .= "LIMIT 1 ";
        $query .= ";";
        $subject = mysqli_query($connection,$query);
        confirm_query($subject);
        if($subject = mysqli_fetch_assoc($subject)){
            return $subject;
        } else{
            return null;
        }
    }
    function find_page_by_id($page_id){
        global $connection;

        $safe_id = mysqli_real_escape_string($connection,$page_id);

        $query  = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE id = {$safe_id} ";
        $query .= "LIMIT 1";
        $query .= ";";
        $page = mysqli_query($connection,$query);
        confirm_query($page);
        if($page = mysqli_fetch_assoc($page)){
            return $page;
        } else{
            return null;
        }
    }

	function navigation($subject_id, $page_id)
    {
    $output = "<ul class=\"subjects\">";
    $subject_set = find_all_subjects();

        while ($subject_row = mysqli_fetch_assoc($subject_set)) {

            $output .= "<li";

            if ($subject_id == $subject_row['id']) {
                $output .= " class=\"selected\"";
            }
            $output .= ">";
            $output .= "<a href=\"manage_contents.php?subject=";
            $output .= urlencode($subject_row['id']);
            $output .= "\">";
            $output .= $subject_row['menu_name'];
            $output .= "</a>";

            $page_set = find_pages_for_subject($subject_row['id']);


            $output .= "<ul class=\"pages\">";
            while ($page_row = mysqli_fetch_assoc($page_set)) {
                $output .= "<li";
                if ($page_id == $page_row['id']) {
                    $output .= " class=\"selected\"";
                }
                $output .= ">";
                $output .= "<a href=\"manage_contents.php?page=";
                $output .= urlencode($page_row['id']);
                $output .= "\">";
                $output .= $page_row['menu_name'];
                $output .= "</a></li>";
            }
            $output .= "</ul></li>";
        }
        $output .= "</ul>";
        return $output;
    }