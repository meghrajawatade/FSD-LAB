<?php
// Delete a student using either ID or Roll Number.
include 'db.php';

$error = '';

// Read the delete identifier from the URL.
$deleteId = trim($_GET['id'] ?? '');
$deleteRollno = trim($_GET['rollno'] ?? '');

if ($deleteId !== '') {
    $id = (int) $deleteId;
    $checkResult = mysqli_query($conn, "SELECT id FROM students WHERE id = $id LIMIT 1");

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        if (mysqli_query($conn, "DELETE FROM students WHERE id = $id")) {
            header('Location: display.php?success=' . urlencode('Student deleted successfully.'));
            exit;
        }

        $error = 'Database error while deleting the record.';
    } else {
        $error = 'Student not found.';
    }
} elseif ($deleteRollno !== '') {
    $safeRollno = mysqli_real_escape_string($conn, $deleteRollno);
    $checkResult = mysqli_query($conn, "SELECT id FROM students WHERE rollno = '$safeRollno' LIMIT 1");

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        if (mysqli_query($conn, "DELETE FROM students WHERE rollno = '$safeRollno'")) {
            header('Location: display.php?success=' . urlencode('Student deleted successfully.'));
            exit;
        }

        $error = 'Database error while deleting the record.';
    } else {
        $error = 'Student not found.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a class="top-link" href="display.php">Back to Records</a>
        <h1>Delete Student Record</h1>
        <p class="subtitle">Delete a record using ID or Roll Number.</p>

        <?php if ($error !== ''): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card">
            <div class="search-grid">
                <form action="delete.php" method="get" class="card" style="margin: 0;" onsubmit="return confirmDelete();">
                    <div class="form-group full">
                        <label for="delete_id">Delete by ID</label>
                        <input type="number" id="delete_id" name="id" min="1" required>
                    </div>
                    <div class="button-row">
                        <button type="submit" class="danger-btn">Delete by ID</button>
                    </div>
                </form>

                <form action="delete.php" method="get" class="card" style="margin: 0;" onsubmit="return confirmDelete();">
                    <div class="form-group full">
                        <label for="delete_rollno">Delete by Roll Number</label>
                        <input type="text" id="delete_rollno" name="rollno" required>
                    </div>
                    <div class="button-row">
                        <button type="submit" class="danger-btn">Delete by Roll No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Ask for confirmation before the record is deleted.
        function confirmDelete() {
            return confirm('Are you sure you want to delete this student record?');
        }
    </script>
</body>
</html>
