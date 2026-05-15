<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: signup.php?error=All fields are required.&role=staff");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?error=Invalid email format.&role=staff");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: signup.php?error=Passwords do not match.&role=staff");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password

    // Connect to the database
    $conn = db_connect();
    if ($conn === false) {
        header("Location: signup.php?error=Database connection failed.&role=staff");
        exit();
    }

    // Check if a staff account already exists
    $check_staff_query = $conn->prepare("SELECT id FROM users WHERE role = 'staff' LIMIT 1");
    $check_staff_query->execute();
    $check_staff_query->store_result();

    if ($check_staff_query->num_rows > 0) {
        // Staff account already exists
        $check_staff_query->close();
        $conn->close();
        header("Location: signup.php?error=A staff account already exists. Please log in.&role=staff");
        exit();
    }

    $check_staff_query->close();

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists
        $stmt->close();
        $conn->close();
        header("Location: signup.php?error=Email already exists. Please use a different email.&role=staff");
        exit();
    }

    $stmt->close();

    // Prepare SQL statement to insert the new staff account
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'staff')");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    // Execute and check for errors
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['role'] = 'staff';
        $_SESSION['last_login'] = time();

        setcookie(
            'session_id',
            session_id(),
            time() + 3600, // 1-hour expiry
            '/',
            '',
            true, // Secure
            true  // HttpOnly
        );

        // Redirect with success message
        header("Location: signup.php?success=Staff account created successfully. Please log in.&role=staff");
    } else {
        // Redirect with a general error message
        header("Location: signup.php?error=An unexpected error occurred. Please try again.&role=staff");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: signup.php?error=Invalid request method.&role=staff");
    exit();
}
?>
