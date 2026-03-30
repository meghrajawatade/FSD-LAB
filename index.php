<?php
// Registration form page.
// Any validation errors from insert.php are displayed here.

$error = $_GET['error'] ?? '';
$firstname = $_GET['firstname'] ?? '';
$lastname = $_GET['lastname'] ?? '';
$rollno = $_GET['rollno'] ?? '';
$contact = $_GET['contact'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <a class="top-link" href="display.php">View Student Records</a>
        <h1>Student Registration System</h1>
        <p class="subtitle">PHP + MySQL CRUD application for XAMPP</p>

        <?php if ($error !== ''): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card">
            <form action="insert.php" method="post" onsubmit="return validateForm();">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="rollno">Roll Number / ID</label>
                        <input type="text" id="rollno" name="rollno" value="<?php echo htmlspecialchars($rollno); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="contact">Contact Number</label>
                        <input type="text" id="contact" name="contact" value="<?php echo htmlspecialchars($contact); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                </div>

                <div class="button-row">
                    <button type="submit" class="primary-btn">Register Student</button>
                    <a href="display.php" class="btn-link secondary-btn">View All Records</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Basic JavaScript validation before form submission.
        function validateForm() {
            const firstname = document.getElementById('firstname').value.trim();
            const lastname = document.getElementById('lastname').value.trim();
            const rollno = document.getElementById('rollno').value.trim();
            const contact = document.getElementById('contact').value.trim();
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm_password').value;

            if (!firstname || !lastname || !rollno || !contact || !password || !confirmPassword) {
                alert('All fields are required.');
                return false;
            }

            if (!/^[0-9]+$/.test(contact)) {
                alert('Contact number must be numeric.');
                return false;
            }

            if (password !== confirmPassword) {
                alert('Password and Confirm Password must match.');
                return false;
            }

            return true;
        }
    </script>
</body>
</html>
