<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars($_POST['phone']);
    $role = htmlspecialchars($_POST['role']);
    $cv_file = $_FILES['cv_file'];

    // Validate inputs
    $errors = [];
    if (empty($name)) $errors['name'] = "Name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors['email'] = "Invalid email format.";
    if (empty($phone) || !preg_match('/^\d{10,15}$/', $phone)) $errors['phone'] = "Phone number must be 10-15 digits.";
    if (empty($cv_file['name'])) $errors['cv_file'] = "Please upload your CV.";

    // Validate and process file upload
    if (empty($errors)) {
        $upload_dir = 'uploads/';
        if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true); // Create upload directory if not exists

        $cv_file_name = uniqid() . '_' . basename($cv_file['name']);
        $cv_file_path = $upload_dir . $cv_file_name;

        // Check file type and move uploaded file
        $allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (in_array($cv_file['type'], $allowed_types)) {
            if (move_uploaded_file($cv_file['tmp_name'], $cv_file_path)) {
                // Save the application to the database
                $conn = db_connect();
                $stmt = $conn->prepare("INSERT INTO job_applications (name, email, phone, role, cv_file) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $name, $email, $phone, $role, $cv_file_path);

                if ($stmt->execute()) {
                    $success = "Your application has been submitted successfully.";
                } else {
                    $errors['general'] = "Failed to submit application. Please try again.";
                }

                $stmt->close();
                $conn->close();
            } else {
                $errors['cv_file'] = "Failed to upload your CV. Please try again.";
            }
        } else {
            $errors['cv_file'] = "Invalid file type. Only PDF, DOC, and DOCX files are allowed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Job</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Styling for the header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 50px;
            background-color: #2c3e50;
            color: #fff;
        }

       

        /* Right-side buttons */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-right .btn {
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid #fff;
            border-radius: 4px;
            font-size: 14px;
            color: #fff;
            background-color: transparent;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-right .btn:hover {
            background-color: #fff;
            color: #333;
        }

        

        .nav-right .btn-signup:hover {
            background-color: #fff;
            color: #333;
        }
    </style>
    
</head>
<body>
    <!-- Header -->
    <?php
require_once ('/var/www/html/courseworkWD/courseworkWD/website/html/twig.php'); // Load the Twig environment

// Start the session and set user/session variables for Twig
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Dynamically get the current page name
$current_page = basename($_SERVER['PHP_SELF']); // e.g., 'index.php', 'menu.php'

// Define dynamic variables to pass into Twig
$variables = [
    'current_page' => $current_page,                  // Dynamically set the current page
    'user_is_logged_in' => isset($_SESSION['user_id']), // Check if user is logged in
    'user_role' => $_SESSION['role'] ?? null,          // User role (if logged in)
];

// Render the Twig template
echo $twig->render('header.twig', $variables);
?>

    <main class="reservation-main">
        <section class="reservation-section">
        <img src="images/logos/Lancaster's-logos_transparent.png" alt="Lancaster logo" class="about-intro-logo">
            <h1>Apply for Job</h1>
            <p>Fill out the form below to apply for the position.</p>

            <?php if (!empty($success)): ?>
                <p class="success"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <?php if (!empty($errors['general'])): ?>
                <p class="error"><?= htmlspecialchars($errors['general']) ?></p>
            <?php endif; ?>

            <form class="reservation-form" action="apply.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?= isset($name) ? htmlspecialchars($name) : '' ?>" required>
                    <?php if (!empty($errors['name'])): ?>
                        <p class="error"><?= htmlspecialchars($errors['name']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= isset($email) ? htmlspecialchars($email) : '' ?>" required>
                    <?php if (!empty($errors['email'])): ?>
                        <p class="error"><?= htmlspecialchars($errors['email']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" value="<?= isset($phone) ? htmlspecialchars($phone) : '' ?>" required>
                    <?php if (!empty($errors['phone'])): ?>
                        <p class="error"><?= htmlspecialchars($errors['phone']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="">Select a Role</option>
                        <option value="Waiter" <?= (isset($_GET['role']) && $_GET['role'] === 'Waiter') ? 'selected' : '' ?>>Waiter</option>
                        <option value="Chef" <?= (isset($_GET['role']) && $_GET['role'] === 'Chef') ? 'selected' : '' ?>>Chef</option>
                        <option value="Manager" <?= (isset($_GET['role']) && $_GET['role'] === 'Manager') ? 'selected' : '' ?>>Manager</option>
                        <option value="Cleaner" <?= (isset($_GET['role']) && $_GET['role'] === 'Cleaner') ? 'selected' : '' ?>>Cleaner</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cv_file">Upload CV:</label>
                    <input type="file" id="cv_file" name="cv_file" accept=".pdf,.doc,.docx" required>
                    <?php if (!empty($errors['cv_file'])): ?>
                        <p class="error"><?= htmlspecialchars($errors['cv_file']) ?></p>
                    <?php endif; ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-button">Submit Application</button>
                </div>
            </form>
        </section>
    </main>

    <!-- Footer -->
    <?php
// Include Twig
require_once ('/var/www/html/courseworkWD/courseworkWD/website/html/twig.php');

// Define dynamic variables to pass into Twig
$variables = [
    'current_page' => basename($_SERVER['PHP_SELF']), // Dynamically set current page
];

// Render the footer Twig template
echo $twig->render('footer.twig', $variables);
?>

</body>
</html>
