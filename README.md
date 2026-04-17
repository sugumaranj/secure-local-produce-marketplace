# 🌱 Secure Local Produce Marketplace

A full-stack web application that connects local farmers/sellers with buyers to trade fresh produce securely.

---

## 🚀 Project Overview

This platform allows:

* Sellers to list and manage their agricultural products
* Buyers to browse and purchase local produce
* Secure authentication and role-based access control

Built as a **real-world project** focusing on backend security and scalable design.

---

## 🛠 Tech Stack

* **Frontend:** HTML, CSS
* **Backend:** PHP (Core PHP)
* **Database:** MySQL
* **Server:** Apache (XAMPP/WAMP)

---

## 🔐 Key Features

### ✅ Authentication System

* Secure user registration
* Password hashing using `password_hash()`
* Login verification using `password_verify()`

### ✅ Authorization (Role-Based Access)

* Separate roles: Buyer & Seller
* Role-based redirection after login
* Protected routes to prevent unauthorized access

### ✅ Session Management

* Session-based authentication
* Secure login persistence
* Proper session destruction on logout

### ✅ Security Practices Implemented

* SQL Injection prevention using prepared statements
* Passwords never stored in plain text
* Route protection for restricted pages

---

## 🧱 Database Design

Core tables:

* `users` (buyer/seller roles)
* `products`
* `orders`
* `order_items`
* `categories`

Relational design ensures:

* Data integrity (foreign keys)
* Scalability for future features

---

## 📂 Project Structure

```
local_marketplace/
│
├── config/
│   └── db.php
│
├── auth/
│   ├── register.php
│   ├── login.php
│   └── logout.php
│
├── public/
│   ├── login.html
│   └── register.html
│
├── seller/
│   └── dashboard.php
│
├── buyer/
│   └── home.php
```

---

## 🔄 Current Progress

✔ Database schema designed
✔ User registration system implemented
✔ Secure login system with sessions
✔ Role-based redirection
✔ Route protection implemented
✔ Logout functionality completed

---

## 🚧 Upcoming Features

* Product listing (seller dashboard)
* Buyer storefront UI
* Add to cart system
* Order management system
* Admin panel
* Security enhancements (XSS, CSRF protection)

---

## 🧠 Learning Outcomes

* Secure backend development using PHP
* Authentication & session handling
* Database normalization & relationships
* Real-world application architecture
* Git & GitHub workflow

---

## ⚙️ Setup Instructions

1. Clone the repository
2. Move project to `htdocs` (XAMPP) or `www` (WAMP)
3. Start Apache & MySQL
4. Import database schema in phpMyAdmin
5. Open:

   ```
   http://localhost/local_marketplace/public/register.html
   ```

---

## 📌 Author

Developed as a full-stack project to demonstrate practical web development and security skills.
