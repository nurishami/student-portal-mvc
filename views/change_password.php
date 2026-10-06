<?php

session_start();


// ==========================================
// ACCESS CONTROL
// ==========================================

if (!isset($_SESSION["student_id"])) {
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

    <title>Change Password - Student Portal</title>

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


<!-- ==========================================
     NAVBAR
========================================== -->

<nav class="navbar navbar-dark bg-primary">

    <div class="container">

        <span class="navbar-brand">
            Student Portal
        </span>

        <a
            href="profile.php"
            class="btn btn-light"
        >
            Back to Profile
        </a>

    </div>

</nav>


<!-- ==========================================
     CHANGE PASSWORD FORM
========================================== -->

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4">
                        Change Password
                    </h2>


                    <!-- SUCCESS MESSAGE -->

                    <?php if (isset($_GET["success"])): ?>

                        <div class="alert alert-success">

                            Password updated successfully!

                        </div>

                    <?php endif; ?>


                    <!-- ERROR MESSAGES -->

                    <?php if (isset($_GET["error"])): ?>

                        <?php if ($_GET["error"] === "empty"): ?>

                            <div class="alert alert-warning">
                                Please fill in all fields.
                            </div>

                        <?php elseif ($_GET["error"] === "mismatch"): ?>

                            <div class="alert alert-danger">
                                New passwords do not match.
                            </div>

                        <?php elseif ($_GET["error"] === "oldpassword"): ?>

                            <div class="alert alert-danger">
                                Old password is incorrect.
                            </div>

                        <?php elseif ($_GET["error"] === "update"): ?>

                            <div class="alert alert-danger">
                                Failed to update password.
                            </div>

                        <?php elseif ($_GET["error"] === "student"): ?>

                            <div class="alert alert-danger">
                                Student account could not be found.
                            </div>

                        <?php endif; ?>

                    <?php endif; ?>


                    <form
                        action="../controllers/PasswordController.php"
                        method="POST"
                    >


                        <!-- OLD PASSWORD -->

                        <div class="mb-3">

                            <label
                                for="old_password"
                                class="form-label"
                            >
                                Old Password
                            </label>

                            <input
                                type="password"
                                name="old_password"
                                id="old_password"
                                class="form-control"
                                placeholder="Enter old password"
                                required
                            >

                        </div>


                        <!-- NEW PASSWORD -->

                        <div class="mb-3">

                            <label
                                for="new_password"
                                class="form-label"
                            >
                                New Password
                            </label>

                            <input
                                type="password"
                                name="new_password"
                                id="new_password"
                                class="form-control"
                                placeholder="Enter new password"
                                required
                            >

                        </div>


                        <!-- CONFIRM PASSWORD -->

                        <div class="mb-4">

                            <label
                                for="confirm_password"
                                class="form-label"
                            >
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                name="confirm_password"
                                id="confirm_password"
                                class="form-control"
                                placeholder="Confirm new password"
                                required
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Update Password
                        </button>


                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>