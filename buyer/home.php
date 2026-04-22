<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.html");
    exit();
}

if (time() - $_SESSION["last_activity"] > 600) {
    $_SESSION = [];
    session_destroy();
    header("Location: ../public/login.html");
    exit();
}

if ($_SESSION["role"] == "buyer") {
    $_SESSION["last_activity"] = time();
} else {
    header("Location: ../public/login.html");
    exit();
}

include("../includes/header.php");
include("../config/db.php");

// Fetch products with seller name
$stmt = $conn->prepare("
    SELECT p.*, u.name AS seller_name 
    FROM products p 
    JOIN users u ON p.seller_id = u.id 
    ORDER BY p.created_at DESC
");
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">
    <h3>Marketplace</h3>

    <div class="market-grid">

    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "<div class='market-card'>";

            // IMAGE
            echo "<div class='market-img'>";
            echo "<img src='" . htmlspecialchars($row["image"]) . "' alt='product'>";
            echo "</div>";

            // BODY
            echo "<div class='market-body'>";
            echo "<h4>" . htmlspecialchars($row["name"]) . "</h4>";
            echo "<p class='market-desc'>" . htmlspecialchars($row["description"]) . "</p>";

            echo "<div class='market-footer'>";
            echo "<span class='market-price'>₹" . htmlspecialchars($row["price"]) . "</span>";
            echo "<span class='market-seller'>by " . htmlspecialchars($row["seller_name"]) . "</span>";
            echo "</div>";

            echo "</div>";

            echo "</div>";
        }
    } else {
        echo "<p>No products available</p>";
    }
    ?>

    </div>
</div>

<?php include("../includes/footer.php"); ?>