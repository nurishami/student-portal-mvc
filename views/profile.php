<?php

session_start();

// ==========================================
// ACCESS CONTROL
// ==========================================

// If student is not logged in,
// redirect to login page.
if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}


// ==========================================
// DATABASE + MODEL
// ==========================================

require_once "../config/database.php";
require_once "../models/Student.php";

$studentModel = new Student($conn);


// ==========================================
// GET LOGGED-IN STUDENT
// ==========================================

$studentId = $_SESSION["student_id"];

$student = $studentModel->findById($studentId);


// ==========================================
// CHECK STUDENT EXISTS
// ==========================================

if (!$student) {
    session_destroy();

    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Student Profile</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="../assets/css/style.css"
    >

</head>

<body>

<nav class="navbar navbar-dark bg-primary">

    <div class="container">

        <span class="navbar-brand mb-0 h1">
            Student Portal
        </span>

        <a
            href="../controllers/LogoutController.php"
            class="btn btn-light"
        >
            Logout
        </a>

    </div>

</nav>


<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="mb-4">
                        Student Profile
                    </h2>


                    <!-- ==========================================
                         PROFILE PICTURE
                         ========================================== -->

                    <div class="text-center mb-4">

                        <?php if (!empty($student["profile_picture"])): ?>

                            <img
                                src="../uploads/profile_pictures/<?= htmlspecialchars($student["profile_picture"]) ?>"
                                alt="Profile Picture"
                                class="rounded-circle"
                                width="150"
                                height="150"
                                style="object-fit: cover;"
                            >

                        <?php else: ?>

                            <div
                                class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center mx-auto"
                                style="width:150px; height:150px;"
                            >
                                No Photo
                            </div>

                        <?php endif; ?>

                    </div>


                    <!-- ==========================================
                         UPLOAD PROFILE PICTURE
                         ========================================== -->

                    <div class="border rounded p-3 mb-4">

                        <h5 class="mb-3">
                            Update Profile Picture
                        </h5>

                        <form
                            action="../controllers/StudentController.php?action=upload_profile_picture"
                            method="POST"
                            enctype="multipart/form-data"
                        >

                            <div class="mb-3">

                                <label
                                    for="profile_picture"
                                    class="form-label"
                                >
                                    Choose Profile Picture
                                </label>

                                <input
                                    type="file"
                                    name="profile_picture"
                                    id="profile_picture"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png"
                                    required
                                >

                                <small class="text-muted">
                                    Allowed: JPG, JPEG, PNG. Maximum size: 2MB.
                                </small>

                            </div>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Upload Picture
                            </button>

                        </form>

                    </div>


                    <!-- ==========================================
                         SUCCESS / ERROR MESSAGE
                         ========================================== -->

                    <?php if (isset($_GET["success"])): ?>

                        <?php if ($_GET["success"] === "picture"): ?>

                            <div class="alert alert-success">
                                Profile picture uploaded successfully.
                            </div>

                        <?php endif; ?>

                    <?php endif; ?>


                    <?php if (isset($_GET["error"])): ?>

                        <?php if ($_GET["error"] === "size"): ?>

                            <div class="alert alert-danger">
                                File size must not exceed 2MB.
                            </div>

                        <?php elseif ($_GET["error"] === "type"): ?>

                            <div class="alert alert-danger">
                                Only JPG, JPEG and PNG files are allowed.
                            </div>

                        <?php elseif ($_GET["error"] === "no_file"): ?>

                            <div class="alert alert-danger">
                                Please select a file.
                            </div>

                        <?php elseif ($_GET["error"] === "upload"): ?>

                            <div class="alert alert-danger">
                                File upload failed.
                            </div>

                        <?php elseif ($_GET["error"] === "move"): ?>

                            <div class="alert alert-danger">
                                Unable to save the uploaded file.
                            </div>

                        <?php elseif ($_GET["error"] === "database"): ?>

                            <div class="alert alert-danger">
                                Unable to update profile picture in database.
                            </div>

                        <?php endif; ?>

                    <?php endif; ?>


                    <!-- ==========================================
                         STUDENT INFORMATION
                         ========================================== -->

                    <div class="mb-3">

                        <label class="fw-bold">
                            Name
                        </label>

                        <p class="form-control">
                            <?= htmlspecialchars($student["name"]) ?>
                        </p>

                    </div>


                    <div class="mb-3">

                        <label class="fw-bold">
                            NRIC
                        </label>

                        <p class="form-control">
                            <?= htmlspecialchars($student["nric"]) ?>
                        </p>

                    </div>


                    <div class="mb-3">

                        <label class="fw-bold">
                            Programme
                        </label>

                        <p class="form-control">
                            <?= htmlspecialchars($student["programme"]) ?>
                        </p>

                    </div>


                    <div class="mb-3">

                        <label class="fw-bold">
                            Marks
                        </label>

                        <p class="form-control">
                            <?= htmlspecialchars($student["marks"]) ?>
                        </p>

                    </div>


                    <!-- ==========================================
                         BUTTONS
                         ========================================== -->

                    <div class="d-flex gap-2 flex-wrap">

                        <a
                            href="change_password.php"
                            class="btn btn-primary"
                        >
                            Change Password
                        </a>

                        <a
                            href="students.php"
                            class="btn btn-success"
                        >
                            Student Management
                        </a>

                        <a
                            href="security_demo.php"
                            class="btn btn-dark"
                        >
                            Security Demo
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>