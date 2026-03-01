<?php
// ไฟล์: create_admin.php
require 'config/db.php'; // เรียกใช้ connection แบบ PDO ของคุณ

$username = 'admin';
$password = '123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // เข้ารหัสผ่านให้ปลอดภัย
$full_name = 'Administrator';
$role = 'admin';

try {
    $sql = "INSERT INTO `users` (`username`, `password`, `full_name`, `role`) 
            VALUES (:username, :password, :full_name, :role)";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $hashed_password,
        ':full_name' => $full_name,
        ':role' => $role
    ]);

    echo "✅ สร้างบัญชีผู้ใช้ 'admin' สำเร็จแล้ว! (รหัสผ่านคือ 123)";
    
} catch (PDOException $e) {
    echo "🚨 เกิดข้อผิดพลาด: " . $e->getMessage();
}
?>