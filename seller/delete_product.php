<?php
session_start();

// Check login & role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "seller") {
    header("Location: ../public/login.html");
    exit();
}

// Check if ID exists in URL
if (!isset($_GET["id"])) {
    header("Location: view_products.php");
    exit();
}

$productID = $_GET["id"];
$sellerID = $_SESSION["user_id"];

// DB connection
include("../config/db.php");

// Prepare delete query
$stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND seller_id = ?");
$stmt->bind_param("ii", $productID, $sellerID);

// Execute
$stmt->execute();

// Close
$stmt->close();
$conn->close();

// Redirect back
header("Location: view_products.php");
exit();
?>