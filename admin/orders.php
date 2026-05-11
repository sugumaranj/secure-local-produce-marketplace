<?php
session_start();

if ($_SESSION["role"] != "admin") {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");
include("../includes/header.php");

$result = $conn->query("

SELECT

o.*,
u.name AS buyer_name

FROM orders o

JOIN users u
ON o.buyer_id = u.id

ORDER BY o.id DESC

");
?>

<div class="admin-navbar">

    <a href="dashboard.php">Dashboard</a>

    <a href="users.php">Users</a>

    <a href="products.php">Products</a>

    <a href="orders.php" class="active-nav">Orders</a>

</div>

<div class="admin-container">

<h1>All Orders</h1>

<table class="admin-table">

<tr>

<th>Order ID</th>
<th>Buyer</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>

</tr>

<?php

while($row = $result->fetch_assoc()){

?>

<tr>

<td><?php echo $row["id"]; ?></td>

<td><?php echo htmlspecialchars($row["buyer_name"]); ?></td>

<td>₹<?php echo $row["total_amount"]; ?></td>

<td><?php echo $row["status"]; ?></td>

<td><?php echo $row["created_at"]; ?></td>

</tr>

<?php
}
?>

</table>

</div>

<?php include("../includes/footer.php"); ?>