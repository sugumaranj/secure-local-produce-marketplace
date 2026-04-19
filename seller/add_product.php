<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "seller") {
    header("Location: ../public/login.html");
    exit();
}

include("../includes/header.php");
?>

<div class="addProduct">
    <form action="" method="post">

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
            <input type="submit" value="Add Product" id="addProductButton">
        </div>

    </form>
</div>

<?php
include("../includes/footer.php");
?>