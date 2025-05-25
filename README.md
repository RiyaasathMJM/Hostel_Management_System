# 🏨 Hostel Management System

This project is a **web-based Hostel Management System** designed to manage student, staff, room allocation, payments, and admin approvals. It is built using **PHP**, **MySQL**, and **phpMyAdmin**.

## 📁 Features

- 👨‍🎓 Student and 👩‍💼 Staff registration and login (with unique usernames/passwords)
- 🛏️ Room allocation & availability tracking
- 💵 Payment handling for students
- 📬 Room request system with admin approval
- 🧑‍💼 Admin dashboard for managing requests and room assignments
- 📊 Responsive user dashboard (student, staff, admin)
- 🔐 Secure authentication using password hashing

---

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL (via phpMyAdmin)
- **Tool**: XAMPP / LAMPP / WAMP for local development

---

## 🗄️ Database Schema

The following tables are used:

- `student` – stores student info and login
- `staff` – stores staff info and login
- `admin` – stores admin info and login
- `hostel` – details of each hostel block
- `room` – each room’s availability and occupancy
- `payment` – student payment records
- `room_request` – room request and approval status
- `room_allocation` – final allocated rooms


