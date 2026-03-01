<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
$fullName = $_SESSION['full_name'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการอุปกรณ์กีฬา | ระบบยืม-คืนอุปกรณ์กีฬา</title>
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
            <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:bg-slate-700 hover:text-white rounded-lg transition">
                <i class="fa-solid fa-chart-pie w-5"></i><span class="font-medium">ภาพรวม (Dashboard)</span>
            </a>
            <a href="equipments.php" class="flex items-center gap-3 px-4 py-3 bg-cyan-600/20 text-cyan-400 rounded-lg border border-cyan-500/30 transition">
                <i class="fa-solid fa-table-tennis-paddle-ball w-5"></i><span class="font-medium">จัดการอุปกรณ์กีฬา</span>
            </a>
        </nav>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-16 bg-slate-800/50 backdrop-blur-md border-b border-slate-700 flex items-center justify-between px-8">
            <h2 class="text-xl font-semibold">จัดการอุปกรณ์กีฬา</h2>
            <div class="flex items-center gap-4">
                <p class="text-sm font-medium text-white"><?php echo htmlspecialchars($fullName); ?></p>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            <div class="bg-slate-800 rounded-2xl border border-slate-700 shadow-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-medium text-white">รายการอุปกรณ์ทั้งหมด</h3>
                    <button onclick="openModal()" class="bg-cyan-600 hover:bg-cyan-500 text-white px-4 py-2 rounded-lg transition flex items-center gap-2">
                        <i class="fa-solid fa-plus"></i> เพิ่มอุปกรณ์ใหม่
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-900/50 text-slate-400 text-sm border-b border-slate-700">
                                <th class="p-4 font-medium">ID</th>
                                <th class="p-4 font-medium">ชื่ออุปกรณ์</th>
                                <th class="p-4 font-medium">จำนวนทั้งหมด</th>
                                <th class="p-4 font-medium">พร้อมใช้งาน</th>
                                <th class="p-4 font-medium">สถานะ</th>
                                <th class="p-4 font-medium text-center">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody id="equipmentTableBody">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <div id="equipmentModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center hidden z-50">
        <div class="bg-slate-800 w-full max-w-md rounded-2xl border border-slate-700 shadow-2xl overflow-hidden transform transition-all">
            <div class="px-6 py-4 border-b border-slate-700 flex justify-between items-center bg-slate-800/50">
                <h3 id="modalTitle" class="text-lg font-semibold text-white">เพิ่มอุปกรณ์ใหม่</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white transition"><i class="fa-solid fa-times text-xl"></i></button>
            </div>
            <form id="equipmentForm" class="p-6 space-y-4">
                <input type="hidden" id="eq_id" name="id">
                <input type="hidden" id="eq_action" name="action" value="create">
                
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">ชื่ออุปกรณ์กีฬา</label>
                    <input type="text" id="eq_name" name="name" class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-cyan-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">จำนวนทั้งหมด (ชิ้น)</label>
                    <input type="number" id="eq_qty" name="total_qty" min="1" class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-cyan-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-slate-300 text-sm font-medium mb-1">สถานะ</label>
                    <select id="eq_status" name="status" class="w-full px-4 py-2 rounded-lg bg-slate-900 border border-slate-700 text-white focus:border-cyan-500 outline-none">
                        <option value="active">ปกติ (Active)</option>
                        <option value="inactive">ชำรุด/งดให้บริการ (Inactive)</option>
                    </select>
                </div>
                
                <div class="pt-4 flex gap-3">
                    <button type="button" onclick="closeModal()" class="flex-1 bg-slate-700 hover:bg-slate-600 text-white py-2 rounded-lg transition">ยกเลิก</button>
                    <button type="submit" class="flex-1 bg-cyan-600 hover:bg-cyan-500 text-white py-2 rounded-lg transition">บันทึกข้อมูล</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            loadEquipments();

            // Submit Form (Add/Edit)
            $('#equipmentForm').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serialize();

                $.ajax({
                    url: 'api/equipments.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            closeModal();
                            loadEquipments(); // โหลดตารางใหม่
                            $.alert({ title: 'สำเร็จ!', content: res.message, type: 'green', theme: 'modern' });
                        } else {
                            $.alert({ title: 'ข้อผิดพลาด!', content: res.message, type: 'red', theme: 'modern' });
                        }
                    }
                });
            });
        });

        // ฟังก์ชันโหลดข้อมูล (Read)
        function loadEquipments() {
            $.ajax({
                url: 'api/equipments.php',
                type: 'GET',
                data: { action: 'read' },
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        let html = '';
                        if(res.data.length === 0) {
                            html = `<tr><td colspan="6" class="p-4 text-center text-slate-500">ไม่มีข้อมูลอุปกรณ์</td></tr>`;
                        } else {
                            res.data.forEach(item => {
                                let statusBadge = item.status === 'active' 
                                    ? `<span class="bg-green-500/20 text-green-400 px-2 py-1 rounded text-xs">ปกติ</span>`
                                    : `<span class="bg-red-500/20 text-red-400 px-2 py-1 rounded text-xs">ชำรุด</span>`;
                                
                                html += `
                                    <tr class="border-b border-slate-700/50 hover:bg-slate-800/50 transition">
                                        <td class="p-4 text-slate-400">#${item.id}</td>
                                        <td class="p-4 font-medium text-white">${item.name}</td>
                                        <td class="p-4">${item.total_qty}</td>
                                        <td class="p-4 text-cyan-400">${item.available_qty}</td>
                                        <td class="p-4">${statusBadge}</td>
                                        <td class="p-4 text-center space-x-2">
                                            <button onclick="editEquipment(${item.id}, '${item.name}', ${item.total_qty}, '${item.status}')" class="text-blue-400 hover:text-blue-300 transition" title="แก้ไข"><i class="fa-solid fa-edit"></i></button>
                                            <button onclick="deleteEquipment(${item.id})" class="text-red-400 hover:text-red-300 transition" title="ลบ"><i class="fa-solid fa-trash"></i></button>
                                        </td>
                                    </tr>
                                `;
                            });
                        }
                        $('#equipmentTableBody').html(html);
                    }
                }
            });
        }

        // เปิด Modal เพิ่มข้อมูล
        function openModal() {
            $('#equipmentForm')[0].reset();
            $('#eq_id').val('');
            $('#eq_action').val('create');
            $('#modalTitle').text('เพิ่มอุปกรณ์ใหม่');
            $('#equipmentModal').removeClass('hidden');
        }

        // ปิด Modal
        function closeModal() {
            $('#equipmentModal').addClass('hidden');
        }

        // เตรียมข้อมูลลง Modal แก้ไข
        function editEquipment(id, name, qty, status) {
            $('#eq_id').val(id);
            $('#eq_name').val(name);
            $('#eq_qty').val(qty);
            $('#eq_status').val(status);
            $('#eq_action').val('update');
            $('#modalTitle').text('แก้ไขข้อมูลอุปกรณ์');
            $('#equipmentModal').removeClass('hidden');
        }

        // ฟังก์ชันลบข้อมูล (Delete) ด้วย jQuery Confirm
        function deleteEquipment(id) {
            $.confirm({
                title: 'ยืนยันการลบ!',
                content: 'คุณแน่ใจหรือไม่ว่าต้องการลบอุปกรณ์รายการนี้?',
                type: 'red',
                theme: 'modern',
                buttons: {
                    confirm: {
                        text: 'ลบเลย',
                        btnClass: 'btn-red',
                        action: function () {
                            $.ajax({
                                url: 'api/equipments.php',
                                type: 'POST',
                                data: { action: 'delete', id: id },
                                dataType: 'json',
                                success: function(res) {
                                    if(res.status === 'success') {
                                        loadEquipments(); // โหลดข้อมูลใหม่
                                    } else {
                                        $.alert('เกิดข้อผิดพลาด: ' + res.message);
                                    }
                                }
                            });
                        }
                    },
                    cancel: { text: 'ยกเลิก' }
                }
            });
        }
    </script>
</body>
</html>