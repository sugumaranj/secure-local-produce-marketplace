<?php
require_once("../config/db.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $role = $_POST["role"];

    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        die("All fields are required");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);


    $stmt = $conn->prepare("INSERT INTO users(name,email,password,role) values(?,?,?,?)");
    $stmt->bind_param("ssss",$name,$email,$hashed_password,$role);

    if($stmt->execute()){
        echo "Registration successful";
    }
    else{
        echo "Error: ".$stmt->error;
    }

    $stmt->close();
    $conn->close();
}

?>