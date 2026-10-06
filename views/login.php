<?php

session_start();

// If already logged in, go to profile
if (isset($_SESSION["student_id"])) {
    header("Location: profile.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Student Portal - Login</title>

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

<div class="container">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow mt-5">

                <div class="card-body p-4">

                    <h2 class="text-center mb-4">
                        Student Portal
                    </h2>

                    <h5 class="text-center mb-4">
                        Student Login
                    </h5>

                    <?php if (isset($_GET["error"])): ?>

                        <?php if ($_GET["error"] === "empty"): ?>

                            <div class="alert alert-warning">
                                Please enter your NRIC and password.
                            </div>

                        <?php elseif ($_GET["error"] === "invalid"): ?>

                            <div class="alert alert-danger">
                                Invalid NRIC or password.
                            </div>

                        <?php endif; ?>

                    <?php endif; ?>


                    <form
                        action="../controllers/LoginController.php"
                        method="POST"
                    >

                        <div class="mb-3">

                            <label
                                for="nric"
                                class="form-label"
                            >
                                NRIC
                            </label>

                            <input
                                type="text"
                                name="nric"
                                id="nric"
                                class="form-control"
                                placeholder="Enter your NRIC"
                                required
                            >

                        </div>


                        <div class="mb-3">

                            <label
                                for="password"
                                class="form-label"
                            >
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                id="password"
                                class="form-control"
                                placeholder="Enter your password"
                                required
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Login
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>