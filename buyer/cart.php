<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");
include("../includes/header.php");

// Initialize cart
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}

// 🔥 HANDLE REMOVE ITEM
if (isset($_GET["remove"])) {
    $removeID = $_GET["remove"];
    unset($_SESSION["cart"][$removeID]);
    header("Location: cart.php");
    exit();
}

// 🔥 HANDLE UPDATE QUANTITY
if (isset($_POST["update"])) {
    foreach ($_POST["qty"] as $productID => $qty) {
        $qty = (int)$qty;

        if ($qty <= 0) {
            unset($_SESSION["cart"][$productID]);
        } else {
            $_SESSION["cart"][$productID] = $qty;
        }
    }

    header("Location: cart.php");
    exit();
}

$cart = $_SESSION["cart"];
$total = 0;
?>

<div class="container">
    <h2>Your Cart</h2>

<?php if (empty($cart)) { ?>

    <p>Cart is empty</p>

<?php } else { ?>

<form method="post">

<?php
foreach ($cart as $productID => $qty) {

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $productID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {

        $price = $row["price"];
        $subtotal = $price * $qty;
        $total += $subtotal;
?>

<div class="cart-item">

    <img src="<?php echo htmlspecialchars($row["image"]); ?>" width="100">

    <div>
        <h4><?php echo htmlspecialchars($row["name"]); ?></h4>

        <p>Price: ₹<?php echo htmlspecialchars($price); ?></p>

        <!-- 🔄 Quantity Update -->
        <input type="number" name="qty[<?php echo $productID; ?>]" value="<?php echo $qty; ?>" min="1">

        <p>Subtotal: ₹<?php echo $subtotal; ?></p>

        <!-- ❌ Remove -->
        <a href="cart.php?remove=<?php echo $productID; ?>" class="remove-btn">Remove</a>
    </div>

</div>

<?php
    }
}
?>

<!-- 🔄 Update Button -->
<button type="submit" name="update" class="update-btn">Update Cart</button>

</form>

<!-- 💰 Total -->
<h3>Total: ₹<?php echo $total; ?></h3>

<?php } ?>

</div>

<?php include("../includes/footer.php"); ?>