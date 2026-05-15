<?php
require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['reservation_date'];
    $day_of_week = date('l', strtotime($date)); // Convert date to day of week

    // Connect to the database using the db_connect function
    $conn = db_connect();
    if ($conn === false) {
        throw new Exception("Database connection failed.");
    }

    $query = $conn->prepare("SELECT id, service_name FROM services WHERE day_of_week = ?");
    $query->bind_param("s", $day_of_week);
    $query->execute();
    $result = $query->get_result();

    $services = [];
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }

    echo json_encode($services);
    $conn->close();
}
?>
