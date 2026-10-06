<?php

class Student
{
    private $conn;

    // Constructor
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    // ==============================
    // LOGIN - FIND STUDENT BY NRIC
    // ==============================
    public function findByNRIC($nric)
    {
        $sql = "SELECT * FROM students WHERE nric = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("s", $nric);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }


    // ==============================
    // GET STUDENT BY ID
    // ==============================
    public function findById($id)
    {
        $sql = "SELECT * FROM students WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }


    // ==============================
    // GET ALL STUDENTS
    // ==============================
    public function getAllStudents()
    {
        $sql = "SELECT id, name, nric, programme, marks, created_at
                FROM students
                ORDER BY id DESC";

        $result = $this->conn->query($sql);

        return $result;
    }


    // ==============================
    // CREATE STUDENT
    // ==============================
    public function createStudent(
        $name,
        $nric,
        $programme,
        $marks,
        $password
    ) {
        $sql = "INSERT INTO students
                (name, nric, programme, marks, password)
                VALUES (?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssds",
            $name,
            $nric,
            $programme,
            $marks,
            $password
        );

        return $stmt->execute();
    }


    // ==============================
    // UPDATE STUDENT
    // ==============================
    public function updateStudent(
        $id,
        $name,
        $nric,
        $programme,
        $marks
    ) {
        $sql = "UPDATE students
                SET name = ?,
                    nric = ?,
                    programme = ?,
                    marks = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "sssdi",
            $name,
            $nric,
            $programme,
            $marks,
            $id
        );

        return $stmt->execute();
    }


    // ==============================
    // DELETE STUDENT
    // ==============================
    public function deleteStudent($id)
    {
        $sql = "DELETE FROM students WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }


    // ==============================
    // UPDATE PASSWORD
    // ==============================
    public function updatePassword($id, $password)
    {
        $sql = "UPDATE students
                SET password = ?
                WHERE id = ?";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            die("Prepare failed: " . $this->conn->error);
        }

        $stmt->bind_param(
            "si",
            $password,
            $id
        );

        return $stmt->execute();
    }

    // ==========================================
// GET PASSWORD BY STUDENT ID
// ==========================================
public function getPasswordById($id)
{
    $sql = "SELECT password
            FROM students
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $this->conn->error);
    }

    $stmt->bind_param("i", $id);

    $stmt->execute();

    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

// ==========================================
// UPDATE PROFILE PICTURE
// ==========================================
public function updateProfilePicture($id, $filename)
{
    $sql = "UPDATE students
            SET profile_picture = ?
            WHERE id = ?";

    $stmt = $this->conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: " . $this->conn->error);
    }

    $stmt->bind_param(
        "si",
        $filename,
        $id
    );

    return $stmt->execute();
}

}
?>