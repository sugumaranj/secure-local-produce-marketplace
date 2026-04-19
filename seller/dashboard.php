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
<div class="nav-menu">
    <a href="#">Dashboard</a>
    <a href="#">My Products</a>
    <a href="#">Orders</a>
</div>

<div class="container">
    <h3>Seller Dashboard</h3>

    <div class="cards">
        <div class="card">Total Products</div>
        <div class="card">Orders</div>
        <div class="card">Revenue</div>
    </div>
</div>




<?php include("../includes/footer.php");?>