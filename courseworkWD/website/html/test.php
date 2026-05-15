<?php

$conn = new mysqli("localhost" , "webdev", "W3bD£velopment" , "reservations");

if($conn->connect_error){
    die("connection failed: ".$conn->connect_error);
}else{
    echo"sucess";

}

$sql = "SELECT name, email, phone, reservation_date, reservation_date, reservation_time, guests, requirements FROM reservations";
$result = $conn->query($sql);

if ($result->num_rows > 0){
    echo '<dl>';
    while($row = $result->fetch_assoc()){
        echo "<dt>{$row['name']}</dt><dd>$row[email]</dd>";
    }
    echo '</dl>';
}
else {
    echo '<p>no reservation found</p>';
}
$conn->close();

?>