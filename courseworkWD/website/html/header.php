<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// Get the current file name (e.g., 'index.php', 'about.php')
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Header -->
<header>
    <img src="images/logos/Lancasters-logos_white_c.png" alt="Home Page logo" style="height: 50px;">
    <nav>
        <ul>
            <li><a href="index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">Home</a></li>
            <li><a href="about.php" class="<?= $current_page == 'about.php' ? 'active' : '' ?>">About</a></li>
            <li><a href="gallery.php" class="<?= $current_page == 'gallery.php' ? 'active' : '' ?>">Gallery</a></li>
            <li><a href="careers.php" class="<?= $current_page == 'careers.php' ? 'active' : '' ?>">Careers</a></li>
            <li><a href="menu.php" class="<?= $current_page == 'menu.php' ? 'active' : '' ?>">Menu</a></li>
            <li><a href="reviews.php" class="<?= $current_page == 'reviews.php' ? 'active' : '' ?>">Reviews</a></li>
        </ul>
    </nav>

    <!-- Sign Up and Login Buttons --> 
    <div class="nav-right">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="btn btn-logout">Logout</a>
            <?php if ($_SESSION['role'] == 'staff'): ?>
                <a href="staff_dashboard.php" class="btn">Dashboard</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="signup.php" class="btn btn-signup <?= $current_page == 'signup.php' ? 'active' : '' ?>">Sign Up</a>
            <a href="login.php" class="btn <?= $current_page == 'login.php' ? 'active' : '' ?>">Login</a>
        <?php endif; ?>
    </div>
</header>
