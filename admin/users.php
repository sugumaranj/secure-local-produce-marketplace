<?php
session_start();

if ($_SESSION["role"] != "admin") {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");
include("../includes/header.php");

$result = $conn->query("
    SELECT * FROM users
    ORDER BY id DESC
");
?>

<div class="admin-navbar">

    <a href="dashboard.php">Dashboard</a>

    <a href="users.php" class="active-nav">Users</a>

    <a href="products.php">Products</a>

    <a href="orders.php">Orders</a>

</div>

<div class="admin-container">

<h1>Manage Users</h1>

<table class="admin-table">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Role</th>
</tr>

<?php

while($row = $result->fetch_assoc()){

?>

<tr>

    <td><?php echo $row["id"]; ?></td>

    <td><?php echo htmlspecialchars($row["name"]); ?></td>

    <td><?php echo htmlspecialchars($row["email"]); ?></td>

    <td><?php echo htmlspecialchars($row["role"]); ?></td>

</tr>

<?php
}
?>

</table>

</div>

<?php include("../includes/footer.php"); ?>