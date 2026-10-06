<?php

session_start();

require_once "../config/database.php";
require_once "../models/Student.php";


// ==========================================
// ACCESS CONTROL
// ==========================================

if (!isset($_SESSION["student_id"])) {
    header("Location: ../views/login.php");
    exit();
}


$studentModel = new Student($conn);

$studentId = $_SESSION["student_id"];


// ==========================================
// ONLY PROCESS POST REQUEST
// ==========================================

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../views/change_password.php");
    exit();
}


// ==========================================
// GET FORM DATA
// ==========================================

$oldPassword = $_POST["old_password"] ?? "";
$newPassword = $_POST["new_password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";


// ==========================================
// CHECK EMPTY FIELDS
// ==========================================

if (
    $oldPassword === "" ||
    $newPassword === "" ||
    $confirmPassword === ""
) {
    header("Location: ../views/change_password.php?error=empty");
    exit();
}


// ==========================================
// CHECK NEW PASSWORD MATCH
// ==========================================

if ($newPassword !== $confirmPassword) {
    header("Location: ../views/change_password.php?error=mismatch");
    exit();
}


// ==========================================
// GET CURRENT PASSWORD
// ==========================================

$student = $studentModel->getPasswordById($studentId);

if (!$student) {
    header("Location: ../views/change_password.php?error=student");
    exit();
}


// ==========================================
// VERIFY OLD PASSWORD
// ==========================================

if (!password_verify($oldPassword, $student["password"])) {

    header("Location: ../views/change_password.php?error=oldpassword");
    exit();
}


// ==========================================
// HASH NEW PASSWORD
// ==========================================

$hashedPassword = password_hash(
    $newPassword,
    PASSWORD_DEFAULT
);


// ==========================================
// UPDATE PASSWORD
// ==========================================

if ($studentModel->updatePassword(
    $studentId,
    $hashedPassword
)) {

    header("Location: ../views/change_password.php?success=1");
    exit();

} else {

    header("Location: ../views/change_password.php?error=update");
    exit();
}

?>