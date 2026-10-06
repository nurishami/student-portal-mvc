<?php

session_start();

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

require_once "../config/database.php";
require_once "../models/Student.php";

$studentModel = new Student($conn);


// ==========================================
// GET STUDENT ID
// ==========================================

$id = $_GET["id"] ?? "";

if ($id === "") {
    header("Location: students.php");
    exit();
}


// ==========================================
// GET STUDENT
// ==========================================

$student = $studentModel->findById($id);

if (!$student) {
    header("Location: students.php");
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

    <title>Edit Student</title>

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

        <span class="navbar-brand">
            Student Portal
        </span>

        <a
            href="students.php"
            class="btn btn-light"
        >
            Back to Students
        </a>

    </div>

</nav>


<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="mb-4">
                        Edit Student
                    </h2>


                    <form
                        action="../controllers/StudentController.php?action=update"
                        method="POST"
                    >

                        <!-- STUDENT ID -->

                        <input
                            type="hidden"
                            name="id"
                            value="<?= htmlspecialchars($student["id"]) ?>"
                        >


                        <!-- NAME -->

                        <div class="mb-3">

                            <label
                                for="name"
                                class="form-label"
                            >
                                Student Name
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                value="<?= htmlspecialchars($student["name"]) ?>"
                                required
                            >

                        </div>


                        <!-- NRIC -->

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
                                value="<?= htmlspecialchars($student["nric"]) ?>"
                                required
                            >

                        </div>


                        <!-- PROGRAMME -->

                        <div class="mb-3">

                            <label
                                for="programme"
                                class="form-label"
                            >
                                Programme
                            </label>

                            <input
                                type="text"
                                name="programme"
                                id="programme"
                                class="form-control"
                                value="<?= htmlspecialchars($student["programme"]) ?>"
                                required
                            >

                        </div>


                        <!-- MARKS -->

                        <div class="mb-4">

                            <label
                                for="marks"
                                class="form-label"
                            >
                                Marks
                            </label>

                            <input
                                type="number"
                                name="marks"
                                id="marks"
                                class="form-control"
                                min="0"
                                max="100"
                                step="0.01"
                                value="<?= htmlspecialchars($student["marks"]) ?>"
                                required
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Update Student
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>