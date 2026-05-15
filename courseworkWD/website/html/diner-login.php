<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialize error variables
    $errors = [];
    $form_data = [];

    // Get form data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($name)) {
        $errors['name'] = "Name is required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }

    if (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long.";
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match.";
    }

    $form_data = ['name' => $name, 'email' => $email];

    if (empty($errors)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    

        // Connect to the database
        $conn = db_connect();
        if ($conn === false) {
            die('Database connection error: ' . mysqli_connect_error());
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['email'] = "An account with this email already exists.";
        } else {
            // Prepare SQL statement to insert the user
            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, role) 
                VALUES (?, ?, ?, 'diner')"
            );
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                // Log the user in
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

                // Redirect to reservations page
                header("Location: res.php");
                exit();
            } else {
                $errors['general'] = "Error creating the account. Please try again.";
            }

            $stmt->close();
        }

        $conn->close();
    }

    // Pass errors and form data back to the session
    $_SESSION['signup_errors'] = $errors;
    $_SESSION['form_data'] = $form_data;

    header("Location: signup.php");
    exit();
}
?>
