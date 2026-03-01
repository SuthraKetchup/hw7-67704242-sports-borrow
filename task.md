### 3. `task.md` - แผนการทำงาน

```markdown
# ✅ Task Checklist

> ให้ทำเครื่องหมาย [x] เมื่อภารกิจเสร็จสิ้น เพื่อติดตามความคืบหน้าของโปรเจกต์

## Phase 1: Database & Authentication (เริ่มต้นที่นี่!)
- [x] สร้างไฟล์ `docker-compose.yml` สำหรับ PHP และ MySQL
- [x] นำสคริปต์ SQL ไปรันเพื่อสร้างตาราง `users`, `equipments`, `borrow_records`
- [ ] สร้างไฟล์ `config/database.php` (เชื่อมต่อด้วย PDO แบบ Singleton/Try-Catch)
- [ ] ออกแบบหน้า `index.php` (Login Form) ด้วย Tailwind CSS
- [ ] เขียน `api/auth.php` ตรวจสอบ Login (ป้องกัน SQL Injection)
- [ ] เขียน jQuery AJAX ส่งข้อมูล Login และใช้ jQuery Confirm แจ้งเตือนผลลัพธ์
- [ ] สร้างระบบ Session เบื้องต้น และหน้า `dashboard.php`

## Phase 2: Equipments Management (CRUD)
- [ ] ออกแบบหน้า `equipments.php` (Table Layout + Modal Form) ด้วย Tailwind
- [ ] สร้างระบบ แสดงข้อมูล (Read) ดึงข้อมูลมาแสดงในตารางด้วย AJAX
- [ ] สร้างระบบ เพิ่มข้อมูล (Create) อุปกรณ์กีฬา
- [ ] สร้างระบบ แก้ไขข้อมูล (Update) อุปกรณ์กีฬา
- [ ] สร้างระบบ ลบข้อมูล (Delete) พร้อมทำ Soft Delete หรือ Update Status

## Phase 3: Borrowing System (Core Feature)
- [ ] ออกแบบหน้ายืมอุปกรณ์ และตะกร้าการยืม
- [ ] ตัดสต็อก `available_qty` เมื่อมีการยืม (ใช้ Transaction ใน PDO)
- [ ] สร้างหน้ารายการที่กำลังยืมอยู่ และปุ่มกด "คืนอุปกรณ์"
- [ ] คืนสต็อก `available_qty` เมื่อกดคืนอุปกรณ์สำเร็จ