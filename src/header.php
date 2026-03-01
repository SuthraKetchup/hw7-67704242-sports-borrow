<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Borrowing System</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Sarabun', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

<?php if (isset($_SESSION['user_id'])): ?>
<nav class="bg-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="dashboard.php" class="text-xl font-bold flex items-center gap-2">
            <i class="fa-solid fa-basketball"></i> Sports Borrow
        </a>
        <div class="flex items-center gap-4">
            <span class="hidden md:inline">สวัสดี, <?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
            <a href="dashboard.php" class="hover:text-blue-200 transition">หน้าหลัก</a>
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="equipments.php" class="hover:text-blue-200 transition">จัดการอุปกรณ์</a>
            <?php endif; ?>
            <button onclick="logout()" class="bg-red-500 hover:bg-red-600 px-3 py-1 rounded text-sm transition">
                <i class="fa-solid fa-right-from-bracket"></i> ออกจากระบบ
            </button>
        </div>
    </div>
</nav>

<script>
function logout() {
    window.location.href = 'logout.php';
}
</script>
<?php endif; ?>

<main class="flex-grow container mx-auto px-4 py-6">