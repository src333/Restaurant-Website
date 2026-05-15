<?php
session_start();
require_once ('/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php');

$dinerError = '';
$staffError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // diner or staff

    
     $conn = db_connect(); // Connect to the database

    // Query to check email and role
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ? AND role = ?");
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $email;

            // Redirect based on role
            if ($role === 'diner') {
                header("Location: res.php");
            } elseif ($role === 'staff') {
                header("Location: staff_dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "No account found with that email and role.";
    }

    $stmt->close();
    $conn->close();

    // Assign error to the appropriate role
    if ($role === 'diner') {
        $dinerError = $error;
    } elseif ($role === 'staff') {
        $staffError = $error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lanchester's</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
        .tab-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border: 1px solid #ccc;
            border-radius: 5px 5px 0 0;
            background-color: #f0f0f0;
            margin-right: 5px;
        }
        .tab.active {
            background-color: #fff;
            font-weight: bold;
            border-bottom: 1px solid #fff;
        }
        .tab-content-container {
            background-color: #2c3e50;
            padding: 15px;
            border-radius: 10px;
            width: 600px;
            margin: 20px auto;
        }
        .tab-content-container h2 {
            text-align: center;
        }
        .tab-content {
            border: 1px solid #ccc;
            border-top: none;
            padding: 20px;
            display: none;
            background-color: white;
            border-radius: 10px;
            color: #2c3e50;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .tab-content.active {
            display: block;
        }
        .login-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .login-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .login-form button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .login-form button:hover {
            background-color: #34495e;
        }
        .login-form p {
            text-align: center;
            margin-top: 10px;
            color: #7f8c8d;
        }
        .login-form a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: bold;
        }
        .login-form p a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: center;
        }
        .tab-content img {
            max-width: 150px;
            max-height: 200px;
            margin-left: 190px;
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

    <!-- Tabs for Staff and Diner Login -->
    <div class="tab-container">
        <div class="tab active" data-target="diner-login">Diner Login</div>
        <div class="tab" data-target="staff-login">Staff Login</div>
    </div>

    <div class="tab-content-container">
        <!-- Diner Login Form -->
        <div id="diner-login" class="tab-content active">
        <img src="images/logos/Lancaster's-logos_transparent.png" alt="Lancaster logo" class="login-logo">
            <form class="login-form" action="login.php" method="POST">
                <h2>Diner Login</h2>
                <?php if ($dinerError): ?>
                    <p class="error"><?= htmlspecialchars($dinerError) ?></p>
                <?php endif; ?>
                <input type="hidden" name="role" value="diner">
                <label for="diner-email">Email:</label>
                <input type="email" id="diner-email" name="email"  value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                <label for="diner-password">Password:</label>
                <input type="password" id="diner-password" name="password" required>
                <button type="submit">Login</button>
                <p>Don't have an account? <a href="signup.php">Sign up here</a></p>
                <p>Forgot your password? <a href="reset-password.php?role=diner">Reset it here</a></p>
            </form>
        </div>

        <!-- Staff Login Form -->
        <div id="staff-login" class="tab-content">
        <img src="images/logos/Lancaster's-logos_transparent.png" alt="Lancaster logo" class="login-logo">
            <form class="login-form" action="login.php" method="POST">
                <h2>Staff Login</h2>
                <?php if ($staffError): ?>
                    <p class="error"><?= htmlspecialchars($staffError) ?></p>
                <?php endif; ?>
                <input type="hidden" name="role" value="staff">
                <label for="staff-email">Email:</label>
                <input type="email" id="staff-email" name="email"  value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" required>
                <label for="staff-password">Password:</label>
                <input type="password" id="staff-password" name="password" required>
                <button type="submit">Login</button>
                <p>If no staff account exists, create one <a href="signup.php">here</a></p>
                <p>Forgot your password? <a href="reset-password.php?role=staff">Reset it here</a></p>
            </form>
        </div>
    </div>

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


    <script>
        // JavaScript to handle tab switching
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('active'));
                contents.forEach(c => c.classList.remove('active'));

                tab.classList.add('active');
                document.getElementById(tab.dataset.target).classList.add('active');
            });
        });
    </script>
</body>
</html>
