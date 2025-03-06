<?php
if (file_exists("../config.php")) {
    include "db.php";
} else {
    die("Error: config.php file not found.");
}

if (!isset($conn) || !$conn) {
    die("Database Connection Error: " . mysqli_connect_error());
}

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Student ID is required.");
}

$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("No student found with ID: " . $id);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">Website</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="homePage.html">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="viewAllStudents.html">View All Students</a></li>
            </ul>
        </div>
    </div>
</nav>


<div class="container mt-5">
    <div class="card shadow-lg p-4">
        <h2 class="text-center mb-4">Update Student</h2>
        <form id="updateStudentForm">
            <input type="hidden" id="studentId" name="id" value="<?= $student['id']; ?>">

            <div class="mb-3">
                <label for="firstname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $student['firstName']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $student['lastName']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= $student['phone']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $student['email']; ?>" required>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">Update Student</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function () {
        let studentId = new URLSearchParams(window.location.search).get('id');
        if (!studentId) {
            alert("Student ID not found!");
            window.location.href = "viewAllStudents.html";
            return;
        }

        
        $.ajax({
            url: "http://localhost/apidata/apiUpdate.php.php?id=" + studentId, 
            type: "GET",
            dataType: "json",
            success: function (student) {
                console.log(student); 
                if (student) {
                    $("#studentId").val(student.id);
                    $("#firstname").val(student.firstName);
                    $("#lastname").val(student.lastName);
                    $("#phone").val(student.phone);
                    $("#email").val(student.email);
                } else {
                    alert("No student found!");
                    window.location.href = "viewAllStudents.html";
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching student:", error);
                alert("Failed to fetch student data!");
            }
        });
    });
</script>

</body>
</html>