<?php
session_start();

// ตรวจสอบว่ามีการล็อกอินหรือไม่ ถ้าไม่มีให้เด้งกลับไปหน้า login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// ดึงข้อมูลผู้ใช้จาก Session
$fullName = $_SESSION['full_name'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | ระบบยืม-คืนอุปกรณ์กีฬา</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style> body { font-family: 'Kanit', sans-serif; } </style>
</head>
<body class="bg-slate-900 text-slate-200 min-h-screen flex">

    <aside class="w-64 bg-slate-800 border-r border-slate-700 flex flex-col transition-all duration-300">
        <div class="h-16 flex items-center justify-center border-b border-slate-700">
            <h1 class="text-xl font-bold text-cyan-400"><i class="fa-solid fa-basketball fa-bounce mr-2"></i>Sports System</h1>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 bg-cyan-600/20 text-cyan-400 rounded-lg border border-cyan-500/30 transition">
                <i class="fa-solid fa-chart-pie w-5"></i>
                <span class="font-medium">ภาพรวม (Dashboard)</span>
            </a>
            <a href="equipments.php" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-700 hover:text-white rounded-lg transition">
                <i class="fa-solid fa-table-tennis-paddle-ball w-5"></i>
                <span class="font-medium">จัดการอุปกรณ์กีฬา</span>
            </a>
            <a href="borrow_history.php" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-700 hover:text-white rounded-lg transition">
                <i class="fa-solid fa-clipboard-list w-5"></i>
                <span class="font-medium">ประวัติการยืม-คืน</span>
            </a>
        </nav>
        
        <div class="p-4 border-t border-slate-700">
            <button id="btnLogout" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white rounded-lg transition border border-red-500/20">
                <i class="fa-solid fa-right-from-bracket"></i>
                <span>ออกจากระบบ</span>
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-16 bg-slate-800/50 backdrop-blur-md border-b border-slate-700 flex items-center justify-between px-8">
            <h2 class="text-xl font-semibold">ภาพรวมระบบ</h2>
            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-sm font-medium text-white"><?php echo htmlspecialchars($fullName); ?></p>
                    <p class="text-xs text-cyan-400 capitalize">สถานะ: <?php echo htmlspecialchars($role); ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-cyan-600 flex items-center justify-center text-white font-bold text-lg border-2 border-slate-600">
                    <?php echo mb_substr($fullName, 0, 1, 'UTF-8'); ?>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm">อุปกรณ์ทั้งหมด</p>
                        <h3 class="text-2xl font-bold text-white">120 <span class="text-sm font-normal text-slate-400">รายการ</span></h3>
                    </div>
                </div>
                
                <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-yellow-500/20 text-yellow-400 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-hand-holding-hand"></i>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm">กำลังถูกยืม</p>
                        <h3 class="text-2xl font-bold text-white">15 <span class="text-sm font-normal text-slate-400">รายการ</span></h3>
                    </div>
                </div>

                <div class="bg-slate-800 p-6 rounded-2xl border border-slate-700 shadow-lg flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center text-2xl">
                        <i class="fa-solid fa-check-circle"></i>
                    </div>
                    <div>
                        <p class="text-slate-400 text-sm">พร้อมใช้งาน</p>
                        <h3 class="text-2xl font-bold text-white">105 <span class="text-sm font-normal text-slate-400">รายการ</span></h3>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-cyan-900 to-slate-800 rounded-2xl p-8 border border-cyan-700/50 shadow-lg">
                <h2 class="text-2xl font-bold text-white mb-2">ยินดีต้อนรับกลับมา, <?php echo htmlspecialchars($fullName); ?>! 👋</h2>
                <p class="text-cyan-100">ระบบบริหารจัดการยืม-คืนอุปกรณ์กีฬาพร้อมใช้งานแล้ว คุณสามารถจัดการอุปกรณ์และดูประวัติการทำรายการได้จากเมนูด้านซ้ายมือ</p>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            $('#btnLogout').on('click', function(e) {
                e.preventDefault();
                
                $.confirm({
                    title: 'ออกจากระบบ?',
                    content: 'คุณแน่ใจหรือไม่ว่าต้องการออกจากระบบ?',
                    type: 'red',
                    theme: 'modern',
                    icon: 'fa-solid fa-triangle-exclamation',
                    buttons: {
                        confirm: {
                            text: 'ใช่, ออกจากระบบ',
                            btnClass: 'btn-red',
                            action: function () {
                                window.location.href = 'logout.php';
                            }
                        },
                        cancel: {
                            text: 'ยกเลิก',
                            btnClass: 'btn-default'
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>