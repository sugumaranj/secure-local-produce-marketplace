<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");

/* cart check */
if (!isset($_SESSION["cart"]) || empty($_SESSION["cart"])) {
    header("Location: cart.php");
    exit();
}

$buyerID = $_SESSION["user_id"];
$total = 0;

/* calculate total */
foreach ($_SESSION["cart"] as $productID => $qty) {

    $stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $subtotal = $row["price"] * $qty;
    $total += $subtotal;
}

/* insert order */
$status = "pending";

$stmt = $conn->prepare("
    INSERT INTO orders (buyer_id, total_amount, status)
    VALUES (?, ?, ?)
");

$stmt->bind_param("ids", $buyerID, $total, $status);
$stmt->execute();

/* get new order id */
$orderID = $conn->insert_id;

/* insert order items */
foreach ($_SESSION["cart"] as $productID => $qty) {

    $stmt = $conn->prepare("
        SELECT price FROM products WHERE id = ?
    ");

    $stmt->bind_param("i", $productID);
    $stmt->execute();

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $price = $row["price"];

    $stmt = $conn->prepare("
        INSERT INTO order_items
        (order_id, product_id, quantity, price)
        VALUES (?, ?, ?, ?)
    ");

    $stmt->bind_param("iiid", $orderID, $productID, $qty, $price);
    $stmt->execute();
}

/* clear cart */
unset($_SESSION["cart"]);

/* redirect */
header("Location: buyer_orders.php");
exit();
?>