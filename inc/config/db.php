<?php
// Replace with your actual info
$host = 'localhost';
$dbname = 'shop_inventory';
$username = 'root';
$password = '123456';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
