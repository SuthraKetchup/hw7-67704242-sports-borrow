<?php
session_start();

// กำหนด Header ให้ตอบกลับเป็น JSON
header('Content-Type: application/json');

// เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล
require_once '../config/db.php';

// ตรวจสอบสิทธิ์ (ต้อง Login ก่อนถึงจะทำ CRUD ได้)
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized: กรุณาเข้าสู่ระบบ']);
    exit;
}

// รับค่า action ว่าหน้าเว็บต้องการให้ทำอะไร (read, create, update, delete)
$action = $_REQUEST['action'] ?? '';

try {
    switch ($action) {
        case 'read':
            // ดึงข้อมูลอุปกรณ์ทั้งหมด เรียงจากใหม่ไปเก่า
            $stmt = $conn->query("SELECT * FROM `equipments` ORDER BY id DESC");
            $data = $stmt->fetchAll();
            echo json_encode(['status' => 'success', 'data' => $data]);
            break;

        case 'create':
            // รับค่าและทำความสะอาดข้อมูล
            $name = trim($_POST['name'] ?? '');
            $qty = (int)($_POST['total_qty'] ?? 0);
            $status = $_POST['status'] ?? 'active';

            // ตรวจสอบความถูกต้องของข้อมูลเบื้องต้น
            if (empty($name) || $qty <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'กรุณากรอกข้อมูลให้ครบถ้วนและจำนวนต้องมากกว่า 0']);
                exit;
            }

            // เพิ่มข้อมูล (แยก Parameter :total_qty และ :available_qty ป้องกัน Error HY093)
            $sql = "INSERT INTO `equipments` (`name`, `total_qty`, `available_qty`, `status`) 
                    VALUES (:name, :total_qty, :available_qty, :status)";
            
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name, 
                ':total_qty' => $qty, 
                ':available_qty' => $qty, // ตอนเพิ่มใหม่ ของที่พร้อมยืมจะเท่ากับของทั้งหมด
                ':status' => $status
            ]);

            echo json_encode(['status' => 'success', 'message' => 'เพิ่มอุปกรณ์กีฬาเรียบร้อยแล้ว']);
            break;

        case 'update':
            // รับค่าและทำความสะอาดข้อมูล
            $id = (int)($_POST['id'] ?? 0);
            $name = trim($_POST['name'] ?? '');
            $qty = (int)($_POST['total_qty'] ?? 0);
            $status = $_POST['status'] ?? 'active';

            if ($id <= 0 || empty($name) || $qty <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง']);
                exit;
            }

            // แก้ไขข้อมูล (แยก Parameter เช่นเดียวกับตอน Create)
            $sql = "UPDATE `equipments` 
                    SET `name` = :name, `total_qty` = :total_qty, `available_qty` = :available_qty, `status` = :status 
                    WHERE `id` = :id";
                    
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                ':name' => $name, 
                ':total_qty' => $qty, 
                ':available_qty' => $qty, // *หมายเหตุ: หากระบบใหญ่ขึ้น อาจต้องคำนวณ available_qty ใหม่โดยอิงจากของที่ถูกยืมไปแล้วด้วย
                ':status' => $status, 
                ':id' => $id
            ]);

            echo json_encode(['status' => 'success', 'message' => 'อัปเดตข้อมูลอุปกรณ์เรียบร้อยแล้ว']);
            break;

        case 'delete':
            // รับค่าไอดีที่ต้องการลบ
            $id = (int)($_POST['id'] ?? 0);
            
            if ($id <= 0) {
                echo json_encode(['status' => 'error', 'message' => 'ไม่พบไอดีที่ต้องการลบ']);
                exit;
            }

            // ลบข้อมูลแบบ Hard Delete
            $sql = "DELETE FROM `equipments` WHERE `id` = :id";
            $stmt = $conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            echo json_encode(['status' => 'success', 'message' => 'ลบข้อมูลอุปกรณ์เรียบร้อยแล้ว']);
            break;

        default:
            // กรณีส่ง action มาผิดแปลกๆ
            echo json_encode(['status' => 'error', 'message' => 'Invalid action request']);
            break;
    }

} catch (PDOException $e) {
    // ดักจับ Error จาก Database เพื่อให้ Frontend นำไปแสดงผลใน jQuery Confirm ได้
    echo json_encode(['status' => 'error', 'message' => 'Database Error: ' . $e->getMessage()]);
}
?>