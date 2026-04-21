<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "seller") {
    header("Location: ../public/login.html");
    exit();
}

include("../config/db.php");

$sellerID = $_SESSION["user_id"];
$message = "";

// =======================
// GET PRODUCT
// =======================
if (isset($_GET["id"])) {

    $productID = $_GET["id"];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND seller_id = ?");
    $stmt->bind_param("ii", $productID, $sellerID);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $product = $result->fetch_assoc();

        $name = $product["name"];
        $description = $product["description"];
        $price = $product["price"];
        $quantity = $product["quantity"];
        $imagePath = $product["image"]; // ✅ important
    } else {
        echo "Product not found";
        exit();
    }
}

// =======================
// UPDATE PRODUCT
// =======================
if (isset($_POST["update"])) {

    $productID = $_POST["product_id"];
    $name = $_POST["productName"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $sellerID = $_SESSION["user_id"];

    // Default → keep old image
    $finalImagePath = $_POST["old_image"];

    // Check if new image uploaded
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        $image = $_FILES["image"];

        $newName = time() . "_" . basename($image["name"]);
        $targetPath = "../uploads/" . $newName;

        if (move_uploaded_file($image["tmp_name"], $targetPath)) {
            $finalImagePath = $targetPath;
        }
    }

    // Validation
    if (empty($name) || empty($description) || empty($price) || empty($quantity)) {
        $message = "<p class='error'>All fields required</p>";
    } elseif ($price <= 0 || $quantity <= 0) {
        $message = "<p class='error'>Invalid price or quantity</p>";
    } else {

        $stmt = $conn->prepare("UPDATE products SET name=?, description=?, price=?, quantity=?, image=? WHERE id=? AND seller_id=?");
        $stmt->bind_param("ssdisii", $name, $description, $price, $quantity, $finalImagePath, $productID, $sellerID);

        if ($stmt->execute()) {
            header("Location: view_products.php");
            exit();
        } else {
            $message = "<p class='error'>Update failed</p>";
        }
    }
}

include("../includes/header.php");
?>

<div class="addProduct">
    <form method="post" enctype="multipart/form-data">

        <input type="hidden" name="product_id" value="<?php echo $productID; ?>">
        <input type="hidden" name="old_image" value="<?php echo $imagePath; ?>">

        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="productName" value="<?php echo $name; ?>" required>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required><?php echo $description; ?></textarea>
        </div>

        <div class="form-group">
            <label>Price</label>
            <input type="number" name="price" value="<?php echo $price; ?>" required>
        </div>

        <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" value="<?php echo $quantity; ?>" required>
        </div>

        <!-- ✅ SHOW CURRENT IMAGE -->
        <div class="form-group">
            <label>Current Image</label><br>
            <img src="<?php echo $imagePath; ?>" width="120">
        </div>

        <!-- ✅ CHANGE IMAGE -->
        <div class="form-group">
            <label>Change Image (optional)</label>
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <input type="submit" name="update" value="Update Product" id="addProductButton">
        </div>

        <?php echo $message; ?>

    </form>
</div>

<?php include("../includes/footer.php"); ?>