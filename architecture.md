### 2. `architecture.md` - โครงสร้างและฐานข้อมูล

```markdown
# 🏗️ Architecture & Database Design

## 📂 โครงสร้างไฟล์ (File Structure)
```text
sports-borrow-sys/
│
├── config/
│   └── database.php       # ตั้งค่าการเชื่อมต่อ PDO
├── api/
│   ├── auth.php           # จัดการ Login/Logout (AJAX)
│   ├── equipments.php     # CRUD อุปกรณ์กีฬา (AJAX)
│   └── borrows.php        # จัดการระบบยืม-คืน (AJAX)
├── assets/
│   ├── css/
│   │   └── style.css      # Custom CSS (ถ้ามีนอกเหนือจาก Tailwind)
│   └── js/
│       ├── main.js        # ไฟล์ JS หลัก
│       └── ajax_crud.js   # ไฟล์จัดการ AJAX Request
├── includes/
│   ├── header.php         # Navbar & <head>
│   └── footer.php         # Footer & Scripts
├── index.php              # หน้า Login
├── dashboard.php          # หน้าหลักหลัง Login
├── equipments.php         # หน้าจัดการอุปกรณ์ (CRUD)
├── borrow_history.php     # หน้าประวัติการยืม-คืน
├── docker-compose.yml     # ตั้งค่า Docker
└── readme.md