---

# 🌱 Secure Local Produce Marketplace

A web application connecting local farmers (sellers) with buyers to trade fresh produce securely.

---

## 🚀 Tech Stack

* **Frontend:** HTML, CSS
* **Backend:** PHP
* **Database:** MySQL
* **Server:** Apache (XAMPP/WAMP)

---

## 🔐 Features

* Secure user registration & login (`password_hash`, `password_verify`)
* Role-based access (Buyer / Seller)
* Session-based authentication with timeout
* Route protection
* SQL injection prevention (prepared statements)

---

## 🧱 Database

* `users`, `products`, `orders`, `order_items`, `categories`
* Relational design with foreign keys

---

## 📂 Structure

```plaintext
local_marketplace/
├── config/
├── auth/
├── public/
├── seller/
├── buyer/
├── uploads/
```

---

## ✅ Completed

* Authentication system (login/register/logout)
* Role-based redirection & route protection
* Seller dashboard
* Add product with image upload
* View products (seller side)
* Edit & delete products
* Buyer marketplace page
* Modern product card UI with images
* Seller name display in buyer view

---

## 🚧 Upcoming

* Product details page
* Add to cart
* Order system
* Admin panel
* Advanced security (XSS, CSRF)

---

## ⚙️ Setup

1. Clone repository
2. Move to `htdocs`
3. Start Apache & MySQL
4. Import database
5. Open:

```plaintext
http://localhost/local_marketplace/public/register.html
```

---

## 📌 Author

Built as a full-stack project focusing on secure backend development and real-world application design.
