<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ | ระบบยืม-คืนอุปกรณ์กีฬา</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.4/jquery-confirm.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <style> body { font-family: 'Kanit', sans-serif; } </style>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-slate-800/80 backdrop-blur-lg rounded-2xl shadow-lg p-8 border border-slate-700">
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-white tracking-wide mt-4">เข้าสู่ระบบ</h1>
            <p class="text-slate-400 mt-2 text-sm">ระบบยืม-คืนอุปกรณ์กีฬา</p>
        </div>

        <form id="loginForm" class="space-y-6">
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-2" for="username">รหัสนักศึกษา / Username</label>
                <input type="text" id="username" class="w-full px-4 py-3 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none" placeholder="กรอกรหัสนักศึกษา" required>
            </div>
            <div>
                <label class="block text-slate-300 text-sm font-medium mb-2" for="password">รหัสผ่าน / Password</label>
                <input type="password" id="password" class="w-full px-4 py-3 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 outline-none" placeholder="••••••••" required>
            </div>
            <button type="submit" id="btnSubmit" class="w-full bg-cyan-600 hover:bg-cyan-500 text-white font-semibold py-3 px-4 rounded-lg transition flex justify-center items-center">
                เข้าสู่ระบบ
            </button>
        </form>
    </div>

    <script>
$(document).ready(function() {
    $('#loginForm').on('submit', function(e) {
        e.preventDefault(); 
        
        let btn = $('#btnSubmit');
        let originalContent = btn.html();

        // 1. เปลี่ยนสถานะปุ่มเป็นกำลังโหลด (UX: ให้ผู้ใช้รู้ว่าระบบกำลังทำงาน)
        btn.html('<span class="flex items-center">กำลังตรวจสอบ...</span>')
           .prop('disabled', true)
           .addClass('opacity-70 cursor-not-allowed');

        // 2. ส่งข้อมูลไปยังไฟล์ Backend (PHP) ด้วย AJAX
        $.ajax({
            type: 'POST',
            url: 'services/auth_login.php', // ตรวจสอบชื่อไฟล์ให้ตรงกับที่คุณสร้างไว้
            data: $('#loginForm').serialize(), // ส่งค่าจาก input ทั้งหมดใน form
            dataType: 'json',
            success: function(response) {
                // คืนค่าปุ่มกลับเป็นปกติ
                btn.html(originalContent).prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');

                if(response.status === 'success') {
                    // กรณี Login สำเร็จ
                    $.confirm({
                        title: '🎉 สำเร็จ!',
                        content: response.message,
                        type: 'green',
                        theme: 'modern',
                        buttons: { 
                            ok: { 
                                text: 'ไปที่ Dashboard', 
                                btnClass: 'btn-green',
                                action: function() {
                                    window.location.href = 'dashboard.php'; // ไปที่หน้าจัดการ
                                }
                            } 
                        }
                    });
                } else {
                    // กรณี Login ไม่สำเร็จ (User/Password ผิด)
                    $.confirm({
                        title: '🚨 ข้อผิดพลาด!',
                        content: response.message,
                        type: 'red',
                        theme: 'modern',
                        buttons: { 
                            tryAgain: { 
                                text: 'ลองอีกครั้ง', 
                                btnClass: 'btn-red' 
                            } 
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                // กรณีเกิด Error ที่ Server หรือ Path ไฟล์ผิด
                btn.html(originalContent).prop('disabled', false).removeClass('opacity-70 cursor-not-allowed');
                $.alert({
                    title: '🚨 ระบบขัดข้อง',
                    content: 'ไม่สามารถเชื่อมต่อเซิร์ฟเวอร์ได้ (Error: ' + error + ')',
                    type: 'red'
                });
            }
        });
    });
});

    </script>
</body>
</html>
