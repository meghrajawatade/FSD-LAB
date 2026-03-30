<?php
// Display all student records in a table.
include 'db.php';

$success = $_GET['success'] ?? '';
$error = $_GET['error'] ?? '';

$result = mysqli_query($conn, "SELECT * FROM students ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Records</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a class="top-link" href="index.php">Add New Student</a>
        <h1>Student Records</h1>
        <p class="subtitle">All registered students are shown below.</p>

        <?php if ($success !== ''): ?>
            <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <?php if ($error !== ''): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>DB ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Roll No</th>
                        <th>Password</th>
                        <th>Contact</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($row['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($row['rollno']); ?></td>
                                <td><?php echo htmlspecialchars($row['password']); ?></td>
                                <td><?php echo htmlspecialchars($row['contact']); ?></td>
                                <td>
                                    <div class="action-links">
                                        <a class="edit-link" href="update.php?id=<?php echo urlencode($row['id']); ?>">Update</a>
                                        <a class="delete-link" href="delete.php?id=<?php echo urlencode($row['id']); ?>" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7">No records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
