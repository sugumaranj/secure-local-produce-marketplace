<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.html");
    exit();
}

if ($_SESSION["role"] != "seller") {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");
include("../includes/header.php");

$sellerID = $_SESSION["user_id"];

/* =========================
UPDATE ORDER STATUS
========================= */

if (isset($_POST["update_status"])) {

    $orderID = $_POST["order_id"];
    $status = $_POST["status"];

    $stmt = $conn->prepare("
        UPDATE orders o

        JOIN order_items oi
        ON o.id = oi.order_id

        JOIN products p
        ON oi.product_id = p.id

        SET o.status = ?

        WHERE o.id = ?
        AND p.seller_id = ?
    ");

    $stmt->bind_param("sii", $status, $orderID, $sellerID);

    $stmt->execute();

    if ($stmt->affected_rows > 0) {

        $_SESSION["success"] =
        "Order status updated successfully";

    } else {

        $_SESSION["success"] =
        "No changes made";
    }

    header("Location: orders.php");
    exit();
}

/* =========================
FETCH SELLER ORDERS
========================= */

$stmt = $conn->prepare("

    SELECT

        o.id AS order_id,
        o.total_amount,
        o.status,
        o.created_at,

        oi.quantity,
        oi.price,

        p.name AS product_name,
        p.image,

        u.name AS buyer_name

    FROM orders o

    JOIN order_items oi
    ON o.id = oi.order_id

    JOIN products p
    ON oi.product_id = p.id

    JOIN users u
    ON o.buyer_id = u.id

    WHERE p.seller_id = ?

    ORDER BY o.created_at DESC

");

$stmt->bind_param("i", $sellerID);

$stmt->execute();

$result = $stmt->get_result();
?>

<!-- SELLER NAVBAR -->
<div class="seller-navbar">

    <a href="dashboard.php">Dashboard</a>

    <a href="add_product.php">Add Product</a>

    <a href="view_products.php">My Products</a>

    <a href="orders.php" class="active-nav">Orders</a>

</div>

<div class="orders-container">

    <!-- SUCCESS MESSAGE -->
    <?php

    if (isset($_SESSION["success"])) {

        echo "<div class='success-message'>";

        echo $_SESSION["success"];

        echo "</div>";

        unset($_SESSION["success"]);
    }

    ?>

    <h2 class="orders-title">Received Orders</h2>

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

            <!-- STATUS BADGE -->
            <span class="
                status-badge
                <?php echo strtolower($row['status']); ?>
            ">

                <?php
                echo htmlspecialchars($row["status"]);
                ?>

            </span>

        </div>

        <p class="buyer-name">
            Buyer:
            <?php echo htmlspecialchars($row["buyer_name"]); ?>
        </p>

        <p class="order-id">
            Order #<?php echo htmlspecialchars($row["order_id"]); ?>
        </p>

        <p class="order-price">
            ₹<?php echo htmlspecialchars($row["price"]); ?>
        </p>

        <p class="order-qty">
            Quantity:
            <?php echo htmlspecialchars($row["quantity"]); ?>
        </p>

        <p class="order-total">
            Total Amount:
            ₹<?php echo htmlspecialchars($row["total_amount"]); ?>
        </p>

        <p class="order-date">
            Ordered At:
            <?php echo htmlspecialchars($row["created_at"]); ?>
        </p>

        <!-- STATUS UPDATE FORM -->
        <form method="POST" class="status-form">

            <input
                type="hidden"
                name="order_id"
                value="<?php echo $row["order_id"]; ?>"
            >

            <select name="status">

                <option
                    value="pending"
                    <?php
                    if ($row["status"] == "pending")
                    echo "selected";
                    ?>
                >
                    Pending
                </option>

                <option
                    value="completed"
                    <?php
                    if ($row["status"] == "completed")
                    echo "selected";
                    ?>
                >
                    Completed
                </option>

                <option
                    value="cancelled"
                    <?php
                    if ($row["status"] == "cancelled")
                    echo "selected";
                    ?>
                >
                    Cancelled
                </option>

            </select>

            <button
                type="submit"
                name="update_status"
            >
                Update
            </button>

        </form>

    </div>

</div>

<?php

    }

} else {

    echo "<p>No orders received</p>";
}

?>

</div>

<?php include("../includes/footer.php"); ?>