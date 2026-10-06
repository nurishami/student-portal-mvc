<?php

session_start();

// ==========================================
// CHECK LOGIN STATUS
// ==========================================

if (isset($_SESSION["student_id"])) {

    // Student is already logged in
    header("Location: views/profile.php");
    exit();

} else {

    // Student is not logged in
    header("Location: views/login.php");
    exit();

}

?>