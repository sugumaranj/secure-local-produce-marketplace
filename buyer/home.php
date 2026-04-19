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
if($_SESSION["role"]=="buyer"){
    $_SESSION["last_activity"]=time();
}else{
    header("Location:../public/login.html");
    exit();
}

?>

<?php include("../includes/header.php");?>
<div class="container">
    <h3>Buyer Home</h3>
</div>

<?php include("../includes/footer.php");?>