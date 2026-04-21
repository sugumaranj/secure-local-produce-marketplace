<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: ../public/login.html");
    exit();
}
if(time()-$_SESSION["last_activity"]>600){
    $_SESSION=[];
    session_destroy();
    header("Location:../public/login.html");
    exit();
}
if($_SESSION["role"]=="seller"){
    $_SESSION["last_activity"]=time();
}else{
    header("Location:../public/login.html");
    exit();
}

?>

<?php include("../includes/header.php");?>
<?php include("../config/db.php");?>
<div class="nav-menu">
    <a href="#">Dashboard</a>
    <a href="./add_product.php">Add Product</a>
    <a href="./view_products.php">My Products</a>
    <a href="#">Orders</a>
</div>

<div class="container">
    <h3>Seller Dashboard</h3>

    <div class="cards">
        <div class="card">Total Products
            <?php
                $stmt = $conn -> prepare("SELECT COUNT(*) AS total FROM products WHERE seller_id=?");
                $stmt->bind_param("i",$_SESSION["user_id"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();
                $totalProducts = $row["total"];
                echo " : $totalProducts";
            ?>
        </div>
        <div class="card">Orders</div>
        <div class="card">Revenue</div>
    </div>
</div>




<?php include("../includes/footer.php");?>