<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "seller") {
    header("Location: ../public/login.html");
    exit();
}

$message = "";

// Handle form submission
if (isset($_POST["submit"])) {

    include("../config/db.php");

    $productName = $_POST["productName"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $sellerID = $_SESSION["user_id"];
    $image = $_FILES["image"];
    // Validation
    if (empty($productName) || empty($description) || empty($price) || empty($quantity) || empty($image)) {
        $message = "<p class='error'>Please fill all the fields</p>";
    } elseif ($price <= 0) {
        $message = "<p class='error'>Please enter proper value for price</p>";
    } elseif ($quantity <= 0) {
        $message = "<p class='error'>Please enter proper value for quantity</p>";
    } else {
        $fileSize = filesize($image["tmp_name"]);
        if($fileSize>2097152){
            $message = "<p class='error'>Please upload the image within 2 MB</p>";
            exit();
        }
        $tmp = $image["tmp_name"];
        $name = ((string)time()).$image['name'];
        $target = "../uploads/".$name;
        move_uploaded_file($tmp,$target);
        $stmt = $conn->prepare("INSERT INTO products(seller_id,name,description,price,quantity,image) VALUES(?,?,?,?,?,?)");
        $stmt->bind_param("issiis", $sellerID, $productName, $description, $price, $quantity,$target);

        if ($stmt->execute()) {
            $message = "<p class='success'>Product added successfully</p>";
        } else {
            $message = "<p class='error'>Something went wrong</p>";
        }
    }
}

include("../includes/header.php");

?>
<div class="nav-menu">
    <a href="#">Dashboard</a>
    <a href="./add_product.php">Add Product</a>
    <a href="./view_products.php">My Products</a>
    <a href="#">Orders</a>
</div>

<div class="addProduct">
    <form action="" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label for="productName">Product Name</label>
            <input type="text" name="productName" id="productName" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" rows="5" required></textarea>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" required>
        </div>

        <div class="form-group">
            <label for="image">Upload a image</label>
            <input type="file"name="image" id="image" accept= "image/*" required>
        </div>

        <div class="form-group">
            <input type="submit" name="submit" value="Add Product" id="addProductButton">
        </div>
        <?php echo $message; ?>
    </form>
</div>

<?php
include("../includes/footer.php");
?>