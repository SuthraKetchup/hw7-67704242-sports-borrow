<?php
$host = 'db'; 
$dbname = 'sports_borrow_db';
$username = 'dev_user';
$password = 'dev_password';

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    // เปลี่ยนชื่อตัวแปรเป็น $pdo เพื่อให้ตรงกับไฟล์ auth_login.php ที่เราเขียนไว้ก่อนหน้านี้
    $pdo = new PDO($dsn, $username, $password, $options);

} catch (PDOException $e) {
    // 🚩 สำคัญ: ห้ามใช้ die() หรือ echo ข้อความธรรมดา
    // ให้ส่งกลับเป็น JSON เพื่อให้ AJAX ฝั่งหน้าบ้านอ่านรู้เรื่อง
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => '🚨 Database Error: ' . $e->getMessage()
    ]);
    exit; // หยุดการทำงานทันที
}
?>
