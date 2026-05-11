<?php
session_start();

require_once("../config/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    /* VALIDATION */

    if (empty($email) || empty($password)) {

        die("All fields are required");
    }

    /* FETCH USER */

    $stmt = $conn->prepare("
        SELECT id, name, password, role
        FROM users
        WHERE email = ?
    ");

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows === 1) {

        $user = $result->fetch_assoc();

        /* PASSWORD VERIFY */

        if (password_verify($password, $user["password"])) {

            /* SECURE SESSION */

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["name"] = $user["name"];
            $_SESSION["role"] = $user["role"];
            $_SESSION["last_activity"] = time();

            /* ROLE REDIRECTION */

            if ($user["role"] == "admin") {

                header("Location: ../admin/dashboard.php");
                exit();
            }

            else if ($user["role"] == "buyer") {

                header("Location: ../buyer/home.php");
                exit();
            }

            else if ($user["role"] == "seller") {

                header("Location: ../seller/dashboard.php");
                exit();
            }

        } else {

            echo "Invalid password";
        }

    } else {

        echo "User not found";
    }

    $stmt->close();

    $conn->close();
}
?>