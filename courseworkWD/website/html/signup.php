<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Lanchester's</title>
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
        .signup-form label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .signup-form input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .signup-form button {
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
        .signup-form button:hover {
            background-color: #34495e;
        }
        .signup-form p {
            text-align: center;
            margin-top: 10px;
            color: #7f8c8d;
        }
        .signup-form a {
            color: #2c3e50;
            text-decoration: none;
            font-weight: bold;
        }
        .signup-form p a:hover {
            text-decoration: underline;
        }

        .signup-form h2 {
            text-align: center;
        }
        .tab-content img {
            max-width: 150px;
            max-height: 200px;
            margin-left: 190px;
        }
        .form-container .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: left;
        }
        .form-container .success {
            color: green;
            font-size: 14px;
            margin-bottom: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <?php
    require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

    // Check if a staff account already exists
    $conn = db_connect();
    $staff_exists = false;

    if ($conn) {
        $check_staff_query = $conn->query("SELECT COUNT(*) AS staff_count FROM users WHERE role = 'staff'");
        $staff_data = $check_staff_query->fetch_assoc();
        $staff_exists = $staff_data['staff_count'] > 0;
        $check_staff_query->close();
        $conn->close();
    }

    // Extract error or success messages from the query string
    $error_message = isset($_GET['error']) ? htmlspecialchars($_GET['error']) : null;
    $success_message = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : null;
    $role = isset($_GET['role']) ? $_GET['role'] : null;
    ?>

    <!-- Header -->
    <?php
    require_once '/var/www/html/courseworkWD/courseworkWD/website/html/twig.php';
    $current_page = basename($_SERVER['PHP_SELF']);

    $variables = [
        'current_page' => $current_page,
        'user_is_logged_in' => isset($_SESSION['user_id']),
        'user_role' => $_SESSION['role'] ?? null,
    ];

    echo $twig->render('header.twig', $variables);
    ?>

    <!-- Tabs for Sign Up -->
    <div class="tab-container">
        <?php if (!$staff_exists): ?>
            <div class="tab active">Staff Sign Up</div>
        <?php else: ?>
            <div class="tab active" data-target="diner-signup">Diner Sign Up</div>
            <div class="tab" data-target="staff-signup">Staff Sign Up</div>
        <?php endif; ?>
    </div>

    <div class="tab-content-container">
        <?php if (!$staff_exists): ?>
            <!-- Prompt to create a staff account -->
            <div id="staff-signup" class="tab-content active">
                <form class="signup-form" action="staff-signup.php" method="POST">
                <img src="images/logos/Lancaster's-logos_transparent.png" alt="Lancaster logo" class="login-logo">
                    <h2>Create a Staff Account</h2>
                    <?php if ($error_message && $role === 'staff'): ?>
                        <p class="error"><?= $error_message ?></p>
                    <?php endif; ?>
                    <label for="staff-name">Name:</label>
                    <input type="text" id="staff-name" name="name" required>
                    <label for="staff-email">Email:</label>
                    <input type="email" id="staff-email" name="email" required>
                    <label for="staff-password">Password:</label>
                    <input type="password" id="staff-password" name="password" required>
                    <label for="staff-confirm-password">Confirm Password:</label>
                    <input type="password" id="staff-confirm-password" name="confirm_password" required>
                    <button type="submit">Sign Up</button>
                    <p>Already have an account? <a href="login.php">Log in here</a></p>
                </form>
            </div>
        <?php else: ?>
            <!-- Diner Sign-Up -->
            <div id="diner-signup" class="tab-content active">
                <form class="signup-form" action="diner-signup.php" method="POST">
                <img src="images/logos/Lancaster's-logos_transparent.png" alt="Lancaster logo" class="login-logo">
                    <h2>Diner Sign Up</h2>
                    <?php if ($error_message && $role === 'diner'): ?>
                        <p class="error"><?= $error_message ?></p>
                    <?php endif; ?>
                    <?php if ($success_message && $role === 'diner'): ?>
                        <p class="success"><?= $success_message ?></p>
                    <?php endif; ?>
                    <label for="diner-name">Name:</label>
                    <input type="text" id="diner-name" name="name" required>
                    <label for="diner-email">Email:</label>
                    <input type="email" id="diner-email" name="email" required>
                    <label for="diner-password">Password:</label>
                    <input type="password" id="diner-password" name="password" required>
                    <label for="diner-confirm-password">Confirm Password:</label>
                    <input type="password" id="diner-confirm-password" name="confirm_password" required>
                    <button type="submit">Sign Up</button>
                    <p>Already have an account? <a href="login.php">Log in here</a></p>
                </form>
            </div>

            <!-- Staff Sign-Up -->
            <div id="staff-signup" class="tab-content">
                <form class="signup-form" action="staff-signup.php" method="POST">
                <img src="images/logos/Lancaster's-logos_transparent.png" alt="Lancaster logo" class="login-logo">
                    <h2>Staff Sign Up</h2>
                    <?php if ($error_message && $role === 'staff'): ?>
                        <p class="error"><?= $error_message ?></p>
                    <?php endif; ?>
                    <?php if ($success_message && $role === 'staff'): ?>
                        <p class="success"><?= $success_message ?></p>
                    <?php endif; ?>
                    <label for="staff-name">Name:</label>
                    <input type="text" id="staff-name" name="name" required>
                    <label for="staff-email">Email:</label>
                    <input type="email" id="staff-email" name="email" required>
                    <label for="staff-password">Password:</label>
                    <input type="password" id="staff-password" name="password" required>
                    <label for="staff-confirm-password">Confirm Password:</label>
                    <input type="password" id="staff-confirm-password" name="confirm_password" required>
                    <button type="submit">Sign Up</button>
                    <p>Already have an account? <a href="login.php">Log in here</a></p>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <?php
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
                const target = tab.dataset.target;
                if (target) {
                    document.getElementById(target).classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
