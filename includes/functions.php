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
        global $connection;
		if (!$result_set) {
			die("Database query failed: " . mysqli_error($connection));
		}
	}

	function find_all_subjects($public = true){
       	global $connection;

        $query  = "SELECT * ";
        $query .= "FROM subjects ";
            if($public==true){
                $query .= "WHERE visible = 1 ";}
        $query .= "ORDER BY position ASC";
        $query .= ";";
        $subject_set = mysqli_query($connection,$query);
        confirm_query($subject_set);

        return $subject_set;
}
	function find_pages_for_subject($subject_id, $public = true){
		global $connection;

        $query = "SELECT * ";
        $query .= "FROM pages ";
        $query .= "WHERE subject_id = $subject_id ";
            if($public==true){
                $query .= "AND visible = 1 ";}
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
    function find_default_page($subject_id){
        $page_set = find_pages_for_subject($subject_id);
        if($first_page = mysqli_fetch_assoc($page_set)){
            return $first_page['id'];
        }else return null;

    }

    function find_selected_page($public = false){
        global $selected_subject_id;
        global $selected_page_id;

        if(isset($_GET["subject"])){
            $selected_subject_id = $_GET["subject"];
            if($public == true){
                $selected_page_id = find_default_page($selected_subject_id);
            }else $selected_page_id = null;

        }elseif (isset($_GET["page"])){
            $selected_page_id = $_GET["page"];
            $selected_subject_id = null;
        }else {
            $selected_subject_id = null;
            $selected_page_id = null;
        }
    }

	function navigation($subject_id, $page_id){
        $public = false;
    $output = "<ul class=\"subjects\">";
    $subject_set = find_all_subjects(false);

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

            $page_set = find_pages_for_subject($subject_row['id'], false);


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

        $output .= "<br/> <br/> <br/>";


        $output .= "<a id=\"button\" href=\"new_subject.php\"> New Subject</a><br/><br/>";

        $output .= "<a id=\"button\" href=\"new_page.php\"> New Page</a>";
        return $output;
    }
    function public_navigation($subject_id, $page_id){
    $output = "<ul class=\"subjects\">";
    $subject_set = find_all_subjects(true);

    while ($subject_row = mysqli_fetch_assoc($subject_set)) {

        $output .= "<li";

        if ($subject_id == $subject_row['id']) {
            $output .= " class=\"selected\"";
        }
        $output .= ">";
        $output .= "<a href=\"index.php?subject=";
        $output .= urlencode($subject_row['id']);
        $output .= "\">";
        $output .= $subject_row['menu_name'];
        $output .= "</a>";

        if($subject_id == $subject_row['id']) {
            $page_set = find_pages_for_subject($subject_row['id'],true);

            $output .= "<ul class=\"pages\">";
            while ($page_row = mysqli_fetch_assoc($page_set)) {
                $output .= "<li";
                if ($page_id == $page_row['id']) {
                    $output .= " class=\"selected\"";
                }
                $output .= ">";
                $output .= "<a href=\"index.php?page=";
                $output .= urlencode($page_row['id']);
                $output .= "\">";
                $output .= $page_row['menu_name'];
                $output .= "</a></li>";
            }
            $output .= "</ul>";
        }
        $output .= "</li>";
    }
    $output .= "</ul>";
    
    return $output;
}
    function form_errors($errors=array()) {
    $output = "";
    if (!empty($errors)) {
        $output .= "<div class=\"error\">";
        $output .= "Please fix the following errors:";
        $output .= "<ul>";
        foreach ($errors as $key => $error) {
            $output .= "<li>{$error}</li>";
        }
        $output .= "</ul>";
        $output .= "</div>";
    }
    return $output;
}

    function find_all_admins(){
        global $connection;

        $query =  "SELECT * FROM admins ";
        $query .= "ORDER BY username;";

        $admin_set = mysqli_query($connection,$query);
        confirm_query($admin_set);

        return $admin_set;
    };
    function find_admin_by_id($admin_id){
        global $connection;

        $query =  "SELECT * FROM admins ";
        $query .= "WHERE id = $admin_id;";

        $admin = mysqli_query($connection,$query);
        confirm_query($admin);
        $admin = mysqli_fetch_assoc($admin);

        return $admin;
    }
    function find_admin_by_username($username){
    global $connection;

    $username = mysqli_real_escape_string($connection,$username);

    $query =  "SELECT * FROM admins ";
    $query .= "WHERE username = '{$username}';";

    $admin = mysqli_query($connection,$query);
    confirm_query($admin);
    $admin = mysqli_fetch_assoc($admin);

    return $admin;
}
    function find_selected_admin(){
        global $selected_admin;
        if(isset($_GET['id'])){
            $selected_admin = $_GET['id'];
        }else $selected_admin = null;
    }

    function generate_salt($length){
    // Generate a satisfactorily random and unique salt
    // MD5 returns 32 characters
    $unique_random_string = md5(uniqid(mt_rand(),true));

    // Convert to valid characters for a salt: [a-zA-Z0-9./]
    $base64_string = base64_encode($unique_random_string);

    // Previous function converts '.' to '+'. Need to change back
    $modified_base64_string = str_replace('+','.',$base64_string);

    //Truncate the random string to the correct number of characters
    $salt = substr($modified_base64_string,0,$length);

    return $salt;
}
    function password_encrypt($password){
        //Tells PHP to use blowfish (2y) and run the hashing function 10 times
        $hash_format = "$2y$10$";
        //Blowfish salts need to be 22-character long or more
        $salt_length = 22;
        $salt = generate_salt($salt_length);
        $format_and_salt = $hash_format . $salt;
        $hash = crypt($password,$format_and_salt);
            return $hash;
    }
    function password_check($password,$existing_hash){
    //
    $hash = crypt($password,$existing_hash);
    if ($hash === $existing_hash) {
        return true;
    } else {
        return false;
    }
}

    function attempt_login($username,$password){
        $admin = find_admin_by_username($username);

        if($admin){
            if(password_check($password,$admin['hashed_password'])){
                return $admin;
            } else {return false;}
        } else {return false;}
    }

    function log_in_status(){
        return isset($_SESSION['admin_id']);
    }
    function confirm_logged_in(){
        if(!log_in_status()){
          redirect_to('login.php');
        }
    }





