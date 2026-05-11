<?php
session_start();

if ($_SESSION["role"] != "admin") {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");
include("../includes/header.php");

$result = $conn->query("
SELECT p.*, u.name AS seller_name

FROM products p

JOIN users u
ON p.seller_id = u.id

ORDER BY p.id DESC
");
?>

<div class="admin-navbar">

    <a href="dashboard.php">Dashboard</a>

    <a href="users.php">Users</a>

    <a href="products.php" class="active-nav">Products</a>

    <a href="orders.php">Orders</a>

</div>

<div class="admin-container">

<h1>Manage Products</h1>

<table class="admin-table">

<tr>

    <th>Image</th>
    <th>Name</th>
    <th>Price</th>
    <th>Seller</th>

</tr>

<?php

while($row = $result->fetch_assoc()){

?>

<tr>

<td>
<img
src="<?php echo htmlspecialchars($row["image"]); ?>"
width="80">
</td>

<td><?php echo htmlspecialchars($row["name"]); ?></td>

<td>₹<?php echo $row["price"]; ?></td>

<td><?php echo htmlspecialchars($row["seller_name"]); ?></td>

</tr>

<?php
}
?>

</table>

</div>

<?php include("../includes/footer.php"); ?>