# 🌱 Secure Local Produce Marketplace

A modern full-stack agricultural marketplace platform that securely connects local farmers and buyers for fresh produce trading.

Designed with secure backend development, role-based authentication, and a modern glassmorphism-inspired user interface.

---

# 🚀 Tech Stack

## Frontend
- HTML5
- CSS3
- Modern Glassmorphism UI
- Responsive Design

## Backend
- PHP (Core PHP)

## Database
- MySQL

## Server
- Apache (XAMPP/WAMP)

---

# 🔐 Security Features

- Secure user registration and login
- Password hashing using `password_hash()`
- Password verification using `password_verify()`
- Session-based authentication
- Session timeout protection
- Role-based authorization
- Protected routes
- SQL Injection prevention using prepared statements
- Secure image upload handling

---

# 👥 User Roles

## Buyer
- Browse products
- View product details
- Add products to cart
- Manage cart
- Checkout products
- View order history

## Seller
- Seller dashboard
- Add products
- Upload product images
- Edit products
- Delete products
- Manage received orders
- Update order status

## Admin
- Admin dashboard
- Manage users
- Monitor products
- View marketplace statistics
- Manage orders

---

# 🧱 Database Design

Relational database structure with foreign key relationships.

## Main Tables
- `users`
- `products`
- `orders`
- `order_items`
- `categories`

---

# 📂 Project Structure

```plaintext
local_marketplace/
│
├── admin/
├── assets/
│   ├── modern.css
│   ├── login.css
│   └── register.css
│
├── auth/
├── buyer/
├── config/
├── includes/
├── public/
├── seller/
├── uploads/
│
├── index.html
└── README.md
