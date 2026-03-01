# 🤝 Contribution Guidelines

## 🖋 Coding Standards
- **Naming Convention:** 
  - ตัวแปรใน PHP: `$camelCase` (เช่น `$borrowDate`)
  - ไฟล์ PHP: `snake_case.php` (เช่น `get_data.php`)
  - ID/Class ใน HTML: `kebab-case` (เช่น `btn-submit`)
- **Database:** ใช้ PDO Prepared Statements 100% ห้ามใช้ `mysqli_query` หรือใส่ตัวแปรลงใน String SQL โดยตรง

## 🌿 Git Workflow
- **Commit Message Format:** `[Type] Description`
  - `[Feat]` เพิ่มฟีเจอร์ใหม่
  - `[Fix]` แก้ไข Bug
  - `[Docs]` อัปเดตเอกสาร
