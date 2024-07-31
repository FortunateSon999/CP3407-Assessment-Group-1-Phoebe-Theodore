<?php
function getCars($conn) {
    $sql = "SELECT car_id, brand, model, year, color, fuel_type, seat_number, capacity, registration, status, price_per_day, image_path FROM Car";
    return $conn->query($sql);
}
?>
