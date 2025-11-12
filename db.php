<?php
$host = '127.0.0.1';
$db   = 'todo_app';
$user = 'root';     
$pass = '';         
$dsn  = "mysql:host=$host;dbname=$db;charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    // echo "Kết nối CSDL thành công!";
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}
