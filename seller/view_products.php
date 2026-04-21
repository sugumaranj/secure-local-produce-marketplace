<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != "seller") {
    header("Location: ../public/login.html");
    exit();
}
include("../includes/header.php");
?>

<div class="nav-menu">
    <a href="#">Dashboard</a>
    <a href="./add_product.php">Add Product</a>
    <a href="#">My Products</a>
    <a href="#">Orders</a>
</div>

<?php

include("../config/db.php");

$sellerID = $_SESSION["user_id"];
$stmt = $conn->prepare("SELECT * FROM products WHERE seller_id =? ORDER BY created_at");
$stmt->bind_param("i",$sellerID);
$stmt->execute();
$result = $stmt->get_result();
echo "<div id='parentViewProductContainer'>";
if( $result->num_rows > 0 ){
    while($row = $result->fetch_assoc()){
        $productImagePath = $row["image"];
        echo "<div class='viewProductContainer'>";
        echo "<div class='name'>";
        echo $row["name"];
        echo "</div>";
        echo "<div class='description'>";
        echo $row["description"];
        echo "</div>";
        echo "<div class='price'>";
        echo $row["price"].' ₹';
        echo "</div>";
        echo "<div class='quantity'>";
        echo $row["quantity"];
        echo "</div>";
        echo "<div class='image'>";
        echo "<img src='$productImagePath' class='insideContainer'/>";
        echo "</div>";
        echo "</div>";
    }
} 
echo "</div>";


 $stmt->close();
 $conn->close();


?>


<?php
include("../includes/footer.php");
?>