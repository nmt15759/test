<?php
$conn = mysqli_connect("localhost", "root", "", "api");
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8');
?>