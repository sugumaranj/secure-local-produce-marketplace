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
    echo "Welcome " . $_SESSION["name"];
    echo "<a href='../auth/logout.php'>Logout</a>";
}else{
    header("Location:../public/login.html");
    exit();
}

?>