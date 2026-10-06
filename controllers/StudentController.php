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

$action = $_GET["action"] ?? "";


// ==========================================
// CREATE STUDENT
// ==========================================

if ($action === "create") {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: ../views/add_student.php");
        exit();
    }

    $name = trim($_POST["name"] ?? "");
    $nric = trim($_POST["nric"] ?? "");
    $programme = trim($_POST["programme"] ?? "");
    $marks = $_POST["marks"] ?? "";
    $password = $_POST["password"] ?? "";

    if (
        $name === "" ||
        $nric === "" ||
        $programme === "" ||
        $marks === "" ||
        $password === ""
    ) {
        header("Location: ../views/add_student.php?error=empty");
        exit();
    }

    $hashedPassword = password_hash(
        $password,
        PASSWORD_DEFAULT
    );

    if (
        $studentModel->createStudent(
            $name,
            $nric,
            $programme,
            $marks,
            $hashedPassword
        )
    ) {

        header("Location: ../views/students.php?success=created");
        exit();

    } else {

        header("Location: ../views/add_student.php?error=failed");
        exit();
    }
}


// ==========================================
// UPDATE STUDENT
// ==========================================

if ($action === "update") {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: ../views/students.php");
        exit();
    }

    $id = $_POST["id"] ?? "";
    $name = trim($_POST["name"] ?? "");
    $nric = trim($_POST["nric"] ?? "");
    $programme = trim($_POST["programme"] ?? "");
    $marks = $_POST["marks"] ?? "";


    // Validate
    if (
        $id === "" ||
        $name === "" ||
        $nric === "" ||
        $programme === "" ||
        $marks === ""
    ) {

        header("Location: ../views/students.php?error=empty");
        exit();
    }


    // Update student
    if (
        $studentModel->updateStudent(
            $id,
            $name,
            $nric,
            $programme,
            $marks
        )
    ) {

        header("Location: ../views/students.php?success=updated");
        exit();

    } else {

        header("Location: ../views/students.php?error=update");
        exit();
    }
}


// ==========================================
// DELETE STUDENT
// ==========================================

if ($action === "delete") {

    $id = $_GET["id"] ?? "";

    if ($id === "") {
        header("Location: ../views/students.php?error=delete");
        exit();
    }


    if ($studentModel->deleteStudent($id)) {

        header("Location: ../views/students.php?success=deleted");
        exit();

    } else {

        header("Location: ../views/students.php?error=delete");
        exit();
    }
}

// ==========================================
// UPLOAD PROFILE PICTURE
// ==========================================

if ($action === "upload_profile_picture") {

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        header("Location: ../views/profile.php");
        exit();
    }

    $studentId = $_SESSION["student_id"];

    // Check file exists
    if (!isset($_FILES["profile_picture"])) {
        header("Location: ../views/profile.php?error=no_file");
        exit();
    }

    $file = $_FILES["profile_picture"];

    // Check upload error
    if ($file["error"] !== UPLOAD_ERR_OK) {
        header("Location: ../views/profile.php?error=upload");
        exit();
    }

    // Maximum 2MB
    $maxSize = 2 * 1024 * 1024;

    if ($file["size"] > $maxSize) {
        header("Location: ../views/profile.php?error=size");
        exit();
    }

    // Get file extension
    $extension = strtolower(
        pathinfo($file["name"], PATHINFO_EXTENSION)
    );

    // Allowed extensions
    $allowedExtensions = ["jpg", "jpeg", "png"];

    if (!in_array($extension, $allowedExtensions)) {
        header("Location: ../views/profile.php?error=type");
        exit();
    }

    // Check MIME type
    $allowedMimeTypes = [
        "image/jpeg",
        "image/png"
    ];

    $mimeType = mime_content_type($file["tmp_name"]);

    if (!in_array($mimeType, $allowedMimeTypes)) {
        header("Location: ../views/profile.php?error=type");
        exit();
    }

    // Generate secure unique filename
    $newFileName = uniqid("profile_", true) . "." . $extension;

    // Upload directory
    $uploadDirectory = "../uploads/profile_pictures/";

    // Create folder if it does not exist
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true);
    }

    $destination = $uploadDirectory . $newFileName;

    // Move uploaded file
    if (!move_uploaded_file($file["tmp_name"], $destination)) {
        header("Location: ../views/profile.php?error=move");
        exit();
    }

    // Save filename into database
    if ($studentModel->updateProfilePicture($studentId, $newFileName)) {

        header("Location: ../views/profile.php?success=picture");
        exit();

    } else {

        // Remove uploaded file if database update fails
        if (file_exists($destination)) {
            unlink($destination);
        }

        header("Location: ../views/profile.php?error=database");
        exit();
    }
}


// ==========================================
// INVALID ACTION
// ==========================================

header("Location: ../views/students.php");
exit();

?>