<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["home"])) {
        redirectToHome();
    } elseif (isset($_POST["inventory"])) {
        redirectToInventory();
    } elseif (isset($_POST["orders"])) {
        redirectToOrder();
    } elseif (isset($_POST["logout"])) {
        logoutAdmin();
    }
}

function redirectToHome() {
    header("Location: https://kitchencity.com.ph/");
    exit();
}

function redirectToOrder() {
    header("Location: managerorders.php");
    exit();
}

function redirectToInventory() {
    header("Location: managerinventory.php");
    exit();
}

function logoutAdmin() {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            html, body{
                height: 100%;
                margin: 0;
                display: flex;
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                font-family: verdana;
                background-image: url("managerwelcome.jfif");
                background-size: cover;
                background-attachment: fixed;
                background-repeat: no-repeat;
            }
            .container {
                text-align: center;
                margin-top: 360px;
            }
            .menutab {
                border: 1px solid #000000;
                background: none;
                padding: 10px 20px;
                font-size: 20px;
                font-family: "Verdana";
                cursor: pointer;
                margin: 10px;
                transition: 0.8s;
                position: relative;
                overflow: hidden;
                color: #000000;
            }
            .menutab:hover {
                color: #ffffff;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: #FEE135;
            }
            .menutab::before {
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
            .menutab:hover::before {
                height: 100%;
            }
            .header {
                margin-top: 0px;
                position: absolute;
                align-items: center;
                justify-content: center;
                display: flex;
                background-color: #FEE135;
                width: 100%;
                height: 210px;
                outline: auto;
            }
            .heading {
                font-size: 60px;
                color: #362204;
                font-family: verdana;
            }
            .menutab {
                margin-top: 20px;
                text-align: center;
                padding: 50px;
                width: 500px;
                color: black;
                font-size: 20px;
                justify-content: center;
                border-radius: 12px;
                font-style: verdana;
                font-weight: bold;
                cursor: pointer;
                background-color: #FEE135
            }
            .menuformHome{
                margin-top: 225px;
                flex-direction: column;
                display: flex;
                align-items: center;
                text-align: center;
                font-family: verdana;
            }
            .menuformOrder{
                flex-direction: column;
                display: flex;
                align-items: center;
                text-align: center;
                font-family: verdana;
            }
            .menuformInventory{
                flex-direction: column;
                display: flex;
                align-items: center;
                text-align: center;
                font-family: verdana;
            }
            .menuform button {
                margin-right: 5px;
            }
            .logo {
                margin-top: -5px;
                top: 10px;
                left: 10px;
                margin-right: 10px;
                position: absolute;
            }
            .logoutAdminForm{
                margin-top: 60px;
                margin-right: 30px;
                position: absolute;
                right: 10px;
                top: 10px;
            }
            .logoutAdminButton{
                margin-top: 10px;
                padding: 10px;
                width: 200px;
                border-radius: 6px;
                cursor: pointer;
                background-color: #FEE135;
                font-family: verdana;
                font-weight: bold;
                outline: none;
                font-size: 15px;
            }
            .heading {
                text-align: center;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100%;
            }
            .heading span{
                color: white;
                text-transform: uppercase;
                display: block;
            }
            .heading {
                font-size: 60px;
                font-weight: 700;
                letter-spacing: 8px;
                margin-bottom: 8px;
                position: absolute;
                color: #362204;
                animation: text 3s 1;
            }
    
            @keyframes text{
                0%{
                color:bisque;
                margin-button: 40px;
            }
                30%{
                letter-spacing: 25px;
                margin-bottom: -40px;
            }
                85%{
                letter-spacing: 0px;
                margin-bottom: -40px;
            }
            }

            .container{
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #362204;
            }
    
            .logoutAdminButton {
                margin-top: 10px;
                padding: 15px;
                width: 120px;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }
            .logoutAdminButton:hover {
                background-color: #362204;
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="logo">
                <img src="logo.png" style="width:300px;height:200px;">
            </div>
            <b class="heading">Welcome Manager!</b>
            <form class="logoutAdminForm" method="POST">
                <button class="logoutAdminButton" name="logout" type="submit">Logout</button>
            </form>
        </div>
        <form class="menuformHome" method="POST">
            <button type="submit" name="home" class="menutab">Home</button>
        </form>
        <form class="menuformOrder" method="POST">
            <button type="submit" name="orders" class="menutab">Orders</button>
        </form>
    </body>
</html>