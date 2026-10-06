<?php

session_start();

if (!isset($_SESSION["student_id"])) {
    header("Location: login.php");
    exit();
}

require_once "../config/database.php";

$result = null;
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nric = trim($_POST["nric"] ?? "");

    // ==========================================
    // PREPARED STATEMENT
    // ==========================================

    $sql = "SELECT id, name, nric, programme, marks
            FROM students
            WHERE nric = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $nric);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $message = "Student record found.";

    } else {

        $message = "No student record found.";

    }

    $stmt->close();
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

    <title>SQL Injection Prevention</title>

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
            href="profile.php"
            class="btn btn-light"
        >
            Back to Profile
        </a>

    </div>

</nav>


<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="card shadow">

                <div class="card-body p-4">

                    <h2 class="mb-3">
                        SQL Injection Prevention
                    </h2>

                    <p class="text-muted">
                        This page demonstrates how the system
                        protects database queries using
                        Prepared Statements.
                    </p>


                    <form method="POST">

                        <div class="mb-3">

                            <label
                                for="nric"
                                class="form-label"
                            >
                                Enter NRIC
                            </label>

                            <input
                                type="text"
                                name="nric"
                                id="nric"
                                class="form-control"
                                placeholder="Enter NRIC"
                                required
                            >

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Search Student
                        </button>

                    </form>


                    <?php if ($message !== ""): ?>

                        <div class="alert alert-info mt-4">

                            <?= htmlspecialchars($message) ?>

                        </div>

                    <?php endif; ?>


                    <?php if ($result && $result->num_rows > 0): ?>

                        <div class="table-responsive mt-3">

                            <table class="table table-bordered">

                                <thead class="table-dark">

                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>NRIC</th>
                                        <th>Programme</th>
                                        <th>Marks</th>
                                    </tr>

                                </thead>

                                <tbody>

                                <?php while ($student = $result->fetch_assoc()): ?>

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

                                    </tr>

                                <?php endwhile; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php endif; ?>


                    <hr class="my-4">


                    <h5>
                        Security Technique Used
                    </h5>

                    <pre class="bg-light p-3"><code>$stmt = $conn->prepare(
    "SELECT * FROM students WHERE nric = ?"
);

$stmt->bind_param("s", $nric);</code></pre>

                    <p>
                        The user input is bound as a parameter
                        instead of being directly inserted into
                        the SQL statement.
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>