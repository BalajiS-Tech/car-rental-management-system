# 🚗 Online Car Rental Management System

A full-stack web application designed to streamline the car rental process by providing an efficient platform for users to browse, book, and manage rental cars. The system includes both **User Module** and **Admin Module**, enabling real-time booking, car management, and secure authentication.

---

## 🔥 Key Features

### 👤 User Features
- Browse available cars with filters (brand, model, price, type)
- User registration & login
- Real-time booking system
- Booking history & status tracking
- Automatic price calculation based on rental duration

### 🛠 Admin Features
- Manage car inventory (Add / Edit / Delete cars)
- Approve or decline bookings
- Dashboard to monitor active, completed & cancelled rentals
- Track user information

---

## 🧱 System Architecture

```
Frontend  →  React JS / HTML / CSS  
Backend   →  PHP / Node / Python (Based on project setup)  
Database  →  MySQL  
```

---

## 💾 Database Modules

- `users` — Stores login & profile data  
- `cars` — Car list, availability & pricing  
- `bookings` — Booking details & timestamps  
- `admins` — Admin login and privileges  

---

## 📂 Project Structure

```
car-rental-management/
│── config/
│── assets/
│── css/
│── js/
│── backend/
│── database/
│── index.php
│── booking.php
│── login.php
│── admin/
│── README.md
```

---