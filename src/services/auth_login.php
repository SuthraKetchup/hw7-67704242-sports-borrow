<?php
header('Content-Type: application/json');
require_once '../db.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        // Match your table: 'users' and 'username'
        $stmt = $pdo->prepare("SELECT user_id, username, password, fullname, role FROM users WHERE username = ? LIMIT 1");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Store data in Session
            $_SESSION['user_id']  = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['role']     = $user['role'];

            echo json_encode(['status' => 'success', 'message' => 'ยินดีต้อนรับคุณ ' . $user['fullname']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'รหัสนักศึกษาหรือรหัสผ่านไม่ถูกต้อง']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database Error']);
    }
}