<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.html");
    exit();
}

if ($_SESSION["role"] != "admin") {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");
include("../includes/header.php");

/* COUNTS */

$users =
$conn->query("SELECT COUNT(*) AS total FROM users")
->fetch_assoc()["total"];

$products =
$conn->query("SELECT COUNT(*) AS total FROM products")
->fetch_assoc()["total"];

$orders =
$conn->query("SELECT COUNT(*) AS total FROM orders")
->fetch_assoc()["total"];

?>

<div class="admin-navbar">

    <a href="dashboard.php">Dashboard</a>

    <a href="users.php">Users</a>

    <a href="products.php">Products</a>

    <a href="orders.php">Orders</a>

</div>

<div class="admin-container">

    <h1>Admin Dashboard</h1>

    <div class="admin-grid">

        <div class="admin-card">
            <h2><?php echo $users; ?></h2>
            <p>Total Users</p>
        </div>

        <div class="admin-card">
            <h2><?php echo $products; ?></h2>
            <p>Total Products</p>
        </div>

        <div class="admin-card">
            <h2><?php echo $orders; ?></h2>
            <p>Total Orders</p>
        </div>

    </div>

</div>

<?php include("../includes/footer.php"); ?>