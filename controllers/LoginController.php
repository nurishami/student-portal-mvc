<?php

session_start();

require_once "../config/database.php";
require_once "../models/Student.php";

$studentModel = new Student($conn);


// ==========================================
// CHECK REQUEST METHOD
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: ../views/login.php");
    exit();

}


// ==========================================
// GET FORM DATA
// ==========================================

$nric = trim($_POST["nric"] ?? "");
$password = $_POST["password"] ?? "";


// ==========================================
// VALIDATE INPUT
// ==========================================

if ($nric === "" || $password === "") {

    header("Location: ../views/login.php?error=empty");
    exit();

}


// ==========================================
// FIND STUDENT BY NRIC
// ==========================================

$student = $studentModel->findByNRIC($nric);


// ==========================================
// VERIFY STUDENT + PASSWORD
// ==========================================

if ($student && password_verify($password, $student["password"])) {

    // Regenerate session ID for security
    session_regenerate_id(true);

    // Store student information in session
    $_SESSION["student_id"] = $student["id"];
    $_SESSION["student_name"] = $student["name"];

    // Redirect to profile
    header("Location: ../views/profile.php");
    exit();

}


// ==========================================
// LOGIN FAILED
// ==========================================

header("Location: ../views/login.php?error=invalid");
exit();

?>