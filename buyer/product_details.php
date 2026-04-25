<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");

/* 🔥 STEP 1: HANDLE ADD TO CART (VERY IMPORTANT - BEFORE HTML) */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["product_id"])) {

    $productID = $_POST["product_id"];

    // Initialize cart if not exists
    if (!isset($_SESSION["cart"])) {
        $_SESSION["cart"] = [];
    }

    // Increase quantity if already exists
    if (isset($_SESSION["cart"][$productID])) {
        $_SESSION["cart"][$productID]++;
    } else {
        $_SESSION["cart"][$productID] = 1;
    }

    // Redirect to cart page
    header("Location: cart.php");
    exit();
}

include("../includes/header.php");

/* 🔹 STEP 2: VALIDATE GET ID */
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    echo "Invalid request";
    exit();
}

$productID = $_GET["id"];

/* 🔹 STEP 3: FETCH PRODUCT */
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

    <!-- IMAGE -->
    <div class="product-image">
        <img src="<?php echo htmlspecialchars($product["image"]); ?>" alt="product">
    </div>

    <!-- DETAILS -->
    <div class="product-info">
        <h2><?php echo htmlspecialchars($product["name"]); ?></h2>

        <p class="desc"><?php echo htmlspecialchars($product["description"]); ?></p>

        <p class="price">₹<?php echo htmlspecialchars($product["price"]); ?></p>

        <p class="qty">Available: <?php echo htmlspecialchars($product["quantity"]); ?></p>

        <p class="seller">Seller: <?php echo htmlspecialchars($product["seller_name"]); ?></p>

        <!-- 🔥 ADD TO CART FORM -->
        <form method="post">
            <input type="hidden" name="product_id" value="<?php echo $product["id"]; ?>">
            <button type="submit" class="add-to-cart-btn">Add to Cart</button>
        </form>

    </div>

</div>

<?php include("../includes/footer.php"); ?>