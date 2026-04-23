<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");
include("../includes/header.php");

if (!isset($_GET["id"])) {
    echo "Invalid request";
    exit();
}

$productID = $_GET["id"];

$stmt = $conn->prepare("
    SELECT p.*, u.name AS seller_name
    FROM products p
    JOIN users u ON p.seller_id = u.id
    WHERE p.id = ?
");

$stmt->bind_param("i", $productID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Product not found";
    exit();
}

$product = $result->fetch_assoc();
?>

<div class="product-page">

    <div class="product-image">
        <img src="<?php echo htmlspecialchars($product["image"]); ?>">
    </div>

    <div class="product-info">
        <h2><?php echo htmlspecialchars($product["name"]); ?></h2>

        <p class="desc"><?php echo htmlspecialchars($product["description"]); ?></p>

        <p class="price">₹<?php echo htmlspecialchars($product["price"]); ?></p>

        <p class="qty">Available: <?php echo htmlspecialchars($product["quantity"]); ?></p>

        <p class="seller">Seller: <?php echo htmlspecialchars($product["seller_name"]); ?></p>
    </div>

</div>

<?php include("../includes/footer.php"); ?>