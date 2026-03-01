<?php
// เริ่มต้น Session เพื่อเก็บข้อมูลผู้ใช้เมื่อ Login สำเร็จ
session_start();

// กำหนด Header ให้ตอบกลับเป็น JSON
header('Content-Type: application/json');

// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
require_once '../config/db.php';

// ตรวจสอบว่าเป็น Request แบบ POST เท่านั้น
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับค่าและตัดช่องว่างหัวท้าย
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // เช็คว่ากรอกข้อมูลมาครบหรือไม่
    if (empty($username) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'กรุณากรอก Username และ Password ให้ครบถ้วน']);
        exit;
    }

    try {
        // ค้นหาข้อมูลผู้ใช้จาก Username
        $sql = "SELECT `id`, `username`, `password`, `full_name`, `role` FROM `users` WHERE `username` = :username LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        // ตรวจสอบว่าพบผู้ใช้ และรหัสผ่านที่ Hash ไว้ตรงกันหรือไม่
        if ($user && password_verify($password, $user['password'])) {
            
            // เก็บข้อมูลลง Session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // ตอบกลับสถานะสำเร็จ
            echo json_encode([
                'status' => 'success', 
                'message' => 'ยินดีต้อนรับคุณ ' . htmlspecialchars($user['full_name']) . ' กำลังพาท่านเข้าสู่ระบบ...'
            ]);
            
        } else {
            // กรณี Username หรือ Password ไม่ถูกต้อง
            echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง']);
        }

    } catch (PDOException $e) {
        // กรณีเกิดข้อผิดพลาดกับฐานข้อมูล
        echo json_encode(['status' => 'error', 'message' => 'ระบบฐานข้อมูลขัดข้อง: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>