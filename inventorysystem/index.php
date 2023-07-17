<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['role'])) {
        $selectedRole = $_POST['role'];

        if ($selectedRole === 'admin') {
            header("Location: adminlogin.php");
            exit();
        } elseif ($selectedRole === 'manager') {
            header("Location: managerlogin.php");
            exit();
        } else {
            echo "Invalid role. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                font-family: verdana;
                background-image: url('index.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;               
            }
            .header {
                margin-top: 50px;
                text-align: center;
            }
            .heading {
                font-size: 60px;
                color: #362204;
            }
            .login {
                margin-top: 50px;
                display: flex;
            }
            .logo {
                margin-top: 50px;
                justify-content: center;
                align-items: center;
            }
            .managerButton {
                padding: 60px;
                background-color: #362204;
                color: #FEE135;
                border-radius: 12px;
                font-size: 20px;
                font-weight: bold;
                font-family: verdana;
                cursor: pointer;
                flex-direction: row;
                margin-right: 10px;
            }
            .container {
                text-align: center;
                margin-top: 360px;
            }

            .adminButton {
                padding: 60px;
                background-color: #362204;
                color: #FEE135;
                border-radius: 12px;
                font-size: 20px;
                font-weight: bold;
                font-family: verdana;
                flex-direction: row;
                margin-right: 10px;
                border: 1px solid #000000;
                cursor: pointer;
                margin: 10px;
                transition: 1s;
                position: relative;
                overflow: hidden;
            }
            .adminButton:hover {
                color: #ffffff;
                left: 0;
                width: 100%;
                height: 100%;
                background: #f7b709;
            }
            .adminButton::before {
                content: "";
                position: absolute;
                left: 0;
                width: 100%;
                height: 100%;
                background: #c78a2f;
                z-index: -1;
                transition: 0.8s;
                top: 0;
                border-radius: 0 0 50% 50%;
            }
            .adminButton::before {
                height: 100%;
            }
        </style>
    </head>
    <body>
    <div class="logo"> 
            <img src="logo.png" alt="Kitchen City Logo" style="width:500px;height:400px;"> 
        </div>
        <div class="header">
            <b class="heading">A2Z: Food Inventory Management System</b>
        </div>
        <form class="login" method="POST">
            <button class="adminButton" type="submit" name="role" value="admin">Admin Login</button>
            <button class="adminButton" type="submit" name="role" value="manager">Manager Login</button>
        </form>
    </body>
</html>