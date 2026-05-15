<?php
session_start();

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        die("Invalid CSRF token.");
    }

    // Sanitize and validate inputs
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: login.php");
        exit();
    }

    if (empty($password)) {
        $_SESSION['error'] = "Password cannot be empty.";
        header("Location: login.php");
        exit();
    }

    // Connect to database
    //$conn = new mysqli($servername, $username, $password_db, $dbname);
    //if ($conn->connect_error) {
    //    die("Connection failed: " . $conn->connect_error);
    //}

    // Connect to the database
    $conn = db_connect();
    if ($conn === false) {
        die('Database connection error: ' . mysqli_connect_error());
    }




    // Fetch staff details from the database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ? AND role = 'staff'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id();

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = 'staff';

            // Redirect to staff management page
            header("Location: staff_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid credentials. Please try again.";
        }
    } else {
        $_SESSION['error'] = "Invalid credentials. Please try again.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to login page with error
    header("Location: login.php");
    exit();
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method.";
}
?>
