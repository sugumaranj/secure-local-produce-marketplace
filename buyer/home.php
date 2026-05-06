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

/* CART COUNT */
$cartCount = 0;

if (isset($_SESSION["cart"])) {
    $cartCount = count($_SESSION["cart"]);
}

/* SEARCH */
$search = "";

if (isset($_GET["search"])) {
    $search = trim($_GET["search"]);
}

/* FETCH PRODUCTS */
if (!empty($search)) {

    $searchTerm = "%" . $search . "%";

    $stmt = $conn->prepare("
        SELECT p.*, u.name AS seller_name
        FROM products p
        JOIN users u ON p.seller_id = u.id
        WHERE p.name LIKE ?
        OR u.name LIKE ?
        ORDER BY p.created_at DESC
    ");

    $stmt->bind_param("ss", $searchTerm, $searchTerm);

} else {

    $stmt = $conn->prepare("
        SELECT p.*, u.name AS seller_name
        FROM products p
        JOIN users u ON p.seller_id = u.id
        ORDER BY p.created_at DESC
    ");
}

$stmt->execute();
$result = $stmt->get_result();
?>

<div class="container">

    <!-- TOP BAR -->
    <div class="market-topbar">

        <h3>Marketplace</h3>

        <div class="market-actions">

            <!-- SEARCH -->
            <form method="GET" class="search-form">

                <input 
                    type="text"
                    name="search"
                    placeholder="Search products..."
                    value="<?php echo htmlspecialchars($search); ?>"
                >

                <button type="submit">Search</button>

            </form>

            <!-- CART -->
            <a href="cart.php" class="market-btn">
                Cart (<?php echo $cartCount; ?>)
            </a>

            <!-- ORDERS -->
            <a href="buyer_orders.php" class="market-btn">
                My Orders
            </a>

        </div>

    </div>

    <!-- PRODUCT GRID -->
    <div class="market-grid">

    <?php
    if ($result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {

            echo "<a href='product_details.php?id=" . $row["id"] . "' class='card-link'>";

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

            echo "</a>";
        }

    } else {

        echo "<p>No products found</p>";
    }
    ?>

    </div>

</div>

<?php include("../includes/footer.php"); ?>