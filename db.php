<?php
// Database connection file.
// Update these credentials if your local MySQL setup uses different values.
// This file tries a few common combinations so the app is easier to run.

// Turn off mysqli exceptions so we can show a friendly error message.
mysqli_report(MYSQLI_REPORT_OFF);

$servername = getenv('DB_HOST') ?: 'localhost';
$database = getenv('DB_NAME') ?: 'student_db';
$port = (int) (getenv('DB_PORT') ?: 3306);

// Common local credentials to try.
// 1) XAMPP default
// 2) The password used during the MySQL reset flow in this project
// 2) MAMP default
// 3) A sample app user you can create yourself
$credentialPairs = [
    ['root', 'Maze@816'],
    ['root', 'Root@12345!'],
    ['root', ''],
    ['root', 'root'],
    ['student_user', 'student123'],
];

$conn = false;
$lastError = '';

foreach ($credentialPairs as $pair) {
    [$username, $password] = $pair;
    $tryConn = @mysqli_connect($servername, $username, $password, $database, $port);

    if ($tryConn) {
        $conn = $tryConn;
        break;
    }

    $lastError = mysqli_connect_error();
}

// Stop the app if the database connection fails.
if (!$conn) {
    die(
        "Database connection failed. " .
        "Please check your MySQL credentials in db.php. " .
        "Common local options are root/blank, root/root, or a custom user like student_user/student123. " .
        "MySQL error: " . $lastError
    );
}

// Use UTF-8 for safe text handling.
mysqli_set_charset($conn, "utf8mb4");
?>
