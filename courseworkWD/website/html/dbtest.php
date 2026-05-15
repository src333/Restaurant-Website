<?php
require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

$conn = db_connect();
if (!$conn) {
    echo "Database connection error: " . mysqli_connect_error();
} else {
    echo "Database connection successful!";
}
?>
