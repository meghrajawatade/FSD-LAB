<?php
// Insert logic for new student records.
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// Read and trim form values.
$firstname = trim($_POST['firstname'] ?? '');
$lastname = trim($_POST['lastname'] ?? '');
$rollno = trim($_POST['rollno'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');
$contact = trim($_POST['contact'] ?? '');

$errors = [];

// Server-side validation.
if ($firstname === '' || $lastname === '' || $rollno === '' || $password === '' || $confirm_password === '' || $contact === '') {
    $errors[] = 'All fields are required.';
}

if ($password !== $confirm_password) {
    $errors[] = 'Password and Confirm Password must match.';
}

if ($contact !== '' && !ctype_digit($contact)) {
    $errors[] = 'Contact number must be numeric.';
}

// Check roll number uniqueness before insert.
if ($rollno !== '') {
    $safeRollno = mysqli_real_escape_string($conn, $rollno);
    $checkSql = "SELECT id FROM students WHERE rollno = '$safeRollno' LIMIT 1";
    $checkResult = mysqli_query($conn, $checkSql);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $errors[] = 'Roll number must be unique.';
    }
}

// If validation fails, send the user back to the form with the error message.
if (!empty($errors)) {
    $query = http_build_query([
        'error' => implode(' ', $errors),
        'firstname' => $firstname,
        'lastname' => $lastname,
        'rollno' => $rollno,
        'contact' => $contact
    ]);

    header('Location: index.php?' . $query);
    exit;
}

// Escape values for safe SQL insertion.
$safeFirstname = mysqli_real_escape_string($conn, $firstname);
$safeLastname = mysqli_real_escape_string($conn, $lastname);
$safeRollno = mysqli_real_escape_string($conn, $rollno);
$safePassword = mysqli_real_escape_string($conn, $password);
$safeContact = mysqli_real_escape_string($conn, $contact);

// Insert record into the students table.
$insertSql = "INSERT INTO students (firstname, lastname, rollno, password, contact)
              VALUES ('$safeFirstname', '$safeLastname', '$safeRollno', '$safePassword', '$safeContact')";

if (mysqli_query($conn, $insertSql)) {
    header('Location: display.php?success=' . urlencode('Student registered successfully.'));
    exit;
}

// If the database insert fails, show a simple error message.
header('Location: index.php?error=' . urlencode('Database error while inserting the record.'));
exit;
?>
