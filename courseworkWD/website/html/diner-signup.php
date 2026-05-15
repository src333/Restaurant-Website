<?php 
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include the database connection file
require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate form inputs
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: signup.php?error=All fields are required.&role=diner");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?error=Invalid email format.&role=diner");
        exit();
    }

    if ($password !== $confirm_password) {
        header("Location: signup.php?error=Passwords do not match.&role=diner");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash the password

    // Connect to the database
    $conn = db_connect();
    if ($conn === false) {
        header("Location: signup.php?error=Database connection failed.&role=diner");
        exit();
    }

    // Check if at least one staff account exists
    $staff_check_query = $conn->prepare("SELECT id FROM users WHERE role = 'staff' LIMIT 1");
    $staff_check_query->execute();
    $staff_check_query->store_result();

    if ($staff_check_query->num_rows === 0) {
        // No staff account exists
        $staff_check_query->close();
        $conn->close();
        header("Location: signup.php?error=A staff account must be created before a diner account.&role=diner");
        exit();
    }

    $staff_check_query->close();

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already exists
        $stmt->close();
        $conn->close();
        header("Location: signup.php?error=Email already exists. Please use a different email.&role=diner");
        exit();
    }

    $stmt->close();

    // Prepare SQL statement to insert the new diner account
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'diner')");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    // Execute and check for errors
    if ($stmt->execute()) {
        // Set session variables and log the user in
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['role'] = 'diner';
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

        // Redirect to success message
        header("Location: signup.php?success=Diner account created successfully. Please log in.&role=diner");
    } else {
        // Redirect to error message
        header("Location: signup.php?error=An unexpected error occurred. Please try again.&role=diner");
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: signup.php?error=Invalid request method.&role=diner");
    exit();
}
?>
