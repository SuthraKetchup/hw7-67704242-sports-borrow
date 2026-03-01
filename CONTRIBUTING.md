# 🤝 Contributing Guidelines

เพื่อให้การเขียนโค้ดเป็นระเบียบ อ่านง่าย และทำงานร่วมกันได้อย่างมีความสุข โปรดปฏิบัติตามกฎเหล่านี้:

## 📝 Naming Conventions (การตั้งชื่อ)
* **Database Tables & Columns:** ใช้ `snake_case` (เช่น `borrow_records`, `user_id`)
* **PHP Variables & Functions:** ใช้ `camelCase` (เช่น `$userData`, `getEquipmentList()`)
* **HTML/CSS IDs & Classes:** ใช้ `kebab-case` (เช่น `btn-submit`, `login-form`)
* **File Names:** ใช้ `snake_case` สำหรับไฟล์ PHP ทั่วไป (เช่น `borrow_history.php`)

## 💻 Coding Style (รูปแบบโค้ด)
* **PHP PDO:** ต้องใช้ Prepared Statements (`prepare()` และ `execute()`) ทุกครั้งที่มีการรับค่าจาก User ห้ามต่อ String SQL เด็ดขาด!
* **AJAX Responses:** ฝั่ง Backend ต้องตอบกลับเป็น JSON Format เสมอ (`json_encode()`) และกำหนด `header('Content-Type: application/json');`
* **Comments:** อธิบาย "ทำไม" ถึงเขียนโค้ดแบบนี้ มากกว่า "โค้ดนี้คืออะไร" 

## 🌿 Git Commit Format
เราใช้รูปแบบ Conventional Commits เพื่อให้ History ของเราดูโปรและอ่านง่าย:
* `feat: [เพิ่มฟีเจอร์ใหม่]` (เช่น `feat: สร้างระบบ login ด้วย ajax`)
* `fix: [แก้บั๊ก]` (เช่น `fix: แก้ไข query ตัดสต็อกผิดพลาด`)
* `docs: [อัปเดตเอกสาร]` (เช่น `docs: อัปเดต readme เพิ่มวิธีรัน docker`)
* `style: [ปรับแต่ง UI/CSS]` (เช่น `style: ปรับสีปุ่ม login ด้วย tailwind`)
* `refactor: [ปรับปรุงโค้ดโดยไม่เปลี่ยนการทำงาน]`