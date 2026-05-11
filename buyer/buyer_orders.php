<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");
include("../includes/header.php");


$buyerID = $_SESSION["user_id"];

/*
FETCH:
orders
+
products
+
order_items
*/
$stmt = $conn->prepare("
    SELECT 
        o.id AS order_id,
        o.total_amount,
        o.status,
        o.created_at,

        p.name AS product_name,
        p.image,

        oi.quantity,
        oi.price

    FROM orders o

    JOIN order_items oi 
    ON o.id = oi.order_id

    JOIN products p
    ON oi.product_id = p.id

    WHERE o.buyer_id = ?

    ORDER BY o.created_at DESC
");

$stmt->bind_param("i", $buyerID);

$stmt->execute();

$result = $stmt->get_result();
?>
<div class="buyer-navbar">

    <a href="home.php">Marketplace</a>

    <a href="cart.php">
        Cart
        <?php
        if(isset($_SESSION["cart"])){
            echo "(" . count($_SESSION["cart"]) . ")";
        }
        ?>
    </a>

    <a href="buyer_orders.php" class="active-nav">
        My Orders
    </a>

</div>

<div class="orders-container">

    <h2 class="orders-title">My Orders</h2>

<?php

if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {

        ?>

        <div class="modern-order-card">

            <!-- IMAGE -->
            <div class="order-image">

                <img 
                    src="<?php echo htmlspecialchars($row["image"]); ?>" 
                    alt="product"
                >

            </div>

            <!-- DETAILS -->
            <div class="order-details">

               <div class="order-top">
                     <h3>
                        <?php echo htmlspecialchars($row["product_name"]); ?>
                    </h3>

                <span class="
                            status-badge
                 <?php echo strtolower($row['status']); ?>
                ">
                <?php echo htmlspecialchars($row["status"]); ?>
                </span>

                </div>

                <p class="order-id">
                    Order #<?php echo htmlspecialchars($row["order_id"]); ?>
                </p>

                <p class="order-price">
                    ₹<?php echo htmlspecialchars($row["price"]); ?>
                </p>

                <p class="order-qty">
                    Quantity: <?php echo htmlspecialchars($row["quantity"]); ?>
                </p>

                <p class="order-total">
                    Total Amount:
                    ₹<?php echo htmlspecialchars($row["total_amount"]); ?>
                </p>

                <p class="order-date">
                    Ordered At:
                    <?php echo htmlspecialchars($row["created_at"]); ?>
                </p>

            </div>

        </div>

        <?php
    }

} else {

    echo "<p>No orders found</p>";
}
?>

</div>

<?php include("../includes/footer.php"); ?>