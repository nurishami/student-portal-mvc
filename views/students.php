<?php

session_start();

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

require_once "../config/database.php";
require_once "../models/Student.php";

$studentModel = new Student($conn);

$students = $studentModel->getAllStudents();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Student Management</title>

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

        <div>

            <a
                href="profile.php"
                class="btn btn-light me-2"
            >
                Profile
            </a>

            <a
                href="add_student.php"
                class="btn btn-warning"
            >
                + Add Student
            </a>

        </div>

    </div>

</nav>


<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <div
                class="d-flex justify-content-between
                       align-items-center mb-4"
            >

                <h2 class="mb-0">
                    Student Management
                </h2>

                <a
                    href="add_student.php"
                    class="btn btn-primary"
                >
                    + Add Student
                </a>

            </div>


            <!-- SUCCESS MESSAGE -->

            <?php if (isset($_GET["success"])): ?>

                <?php if ($_GET["success"] === "created"): ?>

                    <div class="alert alert-success">
                        Student added successfully!
                    </div>

                <?php elseif ($_GET["success"] === "updated"): ?>

                    <div class="alert alert-success">
                        Student updated successfully!
                    </div>

                <?php elseif ($_GET["success"] === "deleted"): ?>

                    <div class="alert alert-success">
                        Student deleted successfully!
                    </div>

                <?php endif; ?>

            <?php endif; ?>

            <?php if (isset($_GET["error"])): ?>

                <?php if ($_GET["error"] === "empty"): ?>

                    <div class="alert alert-warning">
                        Please fill in all fields.
                    </div>

                <?php elseif ($_GET["error"] === "update"): ?>

                    <div class="alert alert-danger">
                        Failed to update student.
                    </div>

                <?php elseif ($_GET["error"] === "delete"): ?>

                    <div class="alert alert-danger">
                        Failed to delete student.
                    </div>

                <?php endif; ?>

            <?php endif; ?>


            <!-- STUDENT TABLE -->

            <div class="table-responsive">

                <table class="table table-bordered
                              table-hover align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>ID</th>

                            <th>Name</th>

                            <th>NRIC</th>

                            <th>Programme</th>

                            <th>Marks</th>

                            <th>Actions</th>

                        </tr>

                    </thead>


                    <tbody>

                    <?php if ($students && $students->num_rows > 0): ?>

                        <?php while ($student = $students->fetch_assoc()): ?>

                            <tr>

                                <td>
                                    <?= htmlspecialchars($student["id"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student["name"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student["nric"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student["programme"]) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars($student["marks"]) ?>
                                </td>

                                <td>

                                    <a
                                        href="edit_student.php?id=<?= $student["id"] ?>"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        Edit
                                    </a>

                                    <a
                                        href="../controllers/StudentController.php?action=delete&id=<?= $student["id"] ?>"
                                        class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this student?');"
                                    >
                                        Delete
                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td
                                colspan="6"
                                class="text-center"
                            >
                                No students found.
                            </td>

                        </tr>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>