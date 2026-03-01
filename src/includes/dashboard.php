<?php
session_start();

// If session is empty, kick them back to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard | ระบบยืม-คืน</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold">สวัสดี, <?php echo htmlspecialchars($_SESSION['fullname']); ?>!</h1>
        <p class="text-slate-400">ตำแหน่ง: <span class="capitalize"><?php echo $_SESSION['role']; ?></span></p>
        
        <div class="mt-8">
            <a href="logout.php" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded">ออกจากระบบ</a>
        </div>
    </div>
</body>
</html>