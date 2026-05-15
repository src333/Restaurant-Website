<?php
session_start();

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($new_password) < 6) {
        $error = "The new password must be at least 6 characters long.";
    } else {
        // Connect to the database
        $conn = db_connect();
        if ($conn === false) {
            die('Database connection error: ' . mysqli_connect_error());
        }

        // Check if the email and current password match an existing user
        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Verify current password
            if (password_verify($current_password, $user['password'])) {
                // Hash the new password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
                $update_stmt->bind_param("ss", $hashed_password, $email);

                if ($update_stmt->execute()) {
                    $success = "Password updated successfully.";
                } else {
                    $error = "Failed to update password. Please try again.";
                }
                $update_stmt->close();
            } else {
                $error = "Current password is incorrect.";
            }
        } else {
            $error = "No account found with that email address.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Lanchester's</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .form-container {
            width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            border: 15px solid #2c3e50;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-container h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .form-container p {
            margin-bottom: 20px;
            color: #7f8c8d;
        }

        .form-container .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container button {
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .form-container button:hover {
            background-color: #34495e;
        }

        .form-container p.error {
            color: red;
            font-size: 14px;
        }

        .form-container p.success {
            color: green;
            font-size: 14px;
        }

        .form-container .link {
            margin-top: 20px;
            color: #2c3e50;
        }

        .form-container .link a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: bold;
        }

        .form-container .link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .form-container {
                width: 90%;
            }
        }

        .form-container img{
            max-width: 150px;
            max-height: 200px;
            margin-left: 90;


        }

        .error{
            color: #7f8c8d;
        }

        .success{
            color: #7f8c8d;
        }

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

    <!-- Reset Password Form -->
    <main>
        <div class="form-container">
        <img src="images/logos/Lancaster's-logos_transparent.png" alt="Lancaster logo" class="login-logo">
            <h2>Reset Your Password</h2>
            <p>Enter your email, current password, and new password to reset your password.</p>

            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <p class="success"><?= htmlspecialchars($success) ?></p>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                </div>
                <div class="form-group">
                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>
                <div class="form-group">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <button type="submit">Reset Password</button>
            </form>

            <div class="link">
                <p>Remembered your password? <a href="login.php">Log in</a> or <a href="signup.php">Sign up</a> here.</p>
            </div>
        </div>
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
