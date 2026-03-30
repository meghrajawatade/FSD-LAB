<?php
// Update only the contact number of an existing student.
include 'db.php';

$error = '';
$student = null;
$contactValue = '';

// Helper function to fetch a student by ID.
function fetchStudentById($conn, $id)
{
    $id = (int) $id;
    $sql = "SELECT * FROM students WHERE id = $id LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return $result ? mysqli_fetch_assoc($result) : null;
}

// Helper function to fetch a student by Roll Number.
function fetchStudentByRollno($conn, $rollno)
{
    $rollno = mysqli_real_escape_string($conn, trim($rollno));
    $sql = "SELECT * FROM students WHERE rollno = '$rollno' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return $result ? mysqli_fetch_assoc($result) : null;
}

// Read the identifier from either GET or POST.
$searchId = trim($_GET['id'] ?? $_POST['id'] ?? '');
$searchRollno = trim($_GET['rollno'] ?? $_POST['rollno'] ?? '');

// Fetch the student if an ID or Roll Number is provided.
if ($searchId !== '') {
    $student = fetchStudentById($conn, $searchId);
} elseif ($searchRollno !== '') {
    $student = fetchStudentByRollno($conn, $searchRollno);
}

// When the user submits the update form, validate and save the new contact number.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contactValue = trim($_POST['contact'] ?? '');

    if ($contactValue === '') {
        $error = 'Contact number is required.';
    } elseif (!ctype_digit($contactValue)) {
        $error = 'Contact number must be numeric.';
    } elseif (!$student) {
        $error = 'Student not found.';
    } else {
        $safeContact = mysqli_real_escape_string($conn, $contactValue);
        $studentId = (int) $student['id'];
        $updateSql = "UPDATE students SET contact = '$safeContact' WHERE id = $studentId";

        if (mysqli_query($conn, $updateSql)) {
            header('Location: display.php?success=' . urlencode('Student contact updated successfully.'));
            exit;
        }

        $error = 'Database error while updating the record.';
    }
}

// If a student is loaded and no new contact was entered yet, prefill the current contact.
if ($student && $contactValue === '') {
    $contactValue = $student['contact'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Contact</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a class="top-link" href="display.php">Back to Records</a>
        <h1>Update Student Contact</h1>
        <p class="subtitle">Search by Roll Number or ID, then update the contact number.</p>

        <?php if ($error !== ''): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($student): ?>
            <div class="card">
                <h2 style="margin-top: 0;">Student Found</h2>
                <p><strong>DB ID:</strong> <?php echo htmlspecialchars($student['id']); ?></p>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($student['firstname']); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($student['lastname']); ?></p>
                <p><strong>Roll No:</strong> <?php echo htmlspecialchars($student['rollno']); ?></p>
                <p><strong>Current Contact:</strong> <?php echo htmlspecialchars($student['contact']); ?></p>

                <form action="update.php" method="post">
                    <!-- Keep the identifier in hidden fields so the update knows which record to edit. -->
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($student['id']); ?>">
                    <input type="hidden" name="rollno" value="<?php echo htmlspecialchars($student['rollno']); ?>">

                    <div class="form-group full">
                        <label for="contact">New Contact Number</label>
                        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contactValue); ?>" required>
                    </div>

                    <div class="button-row">
                        <button type="submit" class="primary-btn">Update Contact</button>
                    </div>
                </form>
            </div>
        <?php else: ?>
            <div class="card">
                <p class="muted">Use either one of the search forms below.</p>

                <div class="search-grid">
                    <form action="update.php" method="get" class="card" style="margin: 0;">
                        <div class="form-group full">
                            <label for="search_id">Search by ID</label>
                            <input type="number" id="search_id" name="id" min="1" required>
                        </div>
                        <div class="button-row">
                            <button type="submit" class="primary-btn">Find Student</button>
                        </div>
                    </form>

                    <form action="update.php" method="get" class="card" style="margin: 0;">
                        <div class="form-group full">
                            <label for="search_rollno">Search by Roll Number</label>
                            <input type="text" id="search_rollno" name="rollno" required>
                        </div>
                        <div class="button-row">
                            <button type="submit" class="primary-btn">Find Student</button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
