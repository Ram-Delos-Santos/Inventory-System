<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["home"])) {
        redirectToHome();
    } elseif (isset($_POST["supply"])) {
        redirectToSupply();
    } elseif (isset($_POST["inventory"])) {
        redirectToInventory();
    } elseif (isset($_POST["summary"])) {
        redirectToSummary();
    } elseif (isset($_POST["logout"])) {
        logoutAdmin();
    }
    elseif (isset($_POST["useracc"])){
        redirectToUserAcc();
    }elseif (isset($_POST["restock"])){
        redirectToRestock();
    }
}

function redirectToHome() {
    header("Location: https://kitchencity.com.ph/");
    exit();
}

function redirectToSummary() {
    header("Location: summary.php");
    exit();
}

function redirectToSupply() {
    header("Location: supply.php");
    exit();
}

function logoutAdmin() {
    header("Location: index.php");
    exit();
}
function redirectToUserAcc() {
    header("Location: adminuseracc.php");
    exit();
}
function redirectToRestock() {
    header("Location: restock.php");
    exit();
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
                background-image: url("https://images.pexels.com/photos/616401/pexels-photo-616401.jpeg?cs=srgb&dl=pexels-lukas-616401.jpg&fm=jpg");
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
                background: #e2e2e2;
                
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
            }
            .menuformHome{
                margin-top: 225px;
                flex-direction: column;
                display: flex;
                align-items: center;
                text-align: center;
                font-family: verdana;
            }
            .menuformSummary{
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
            .menuformSupplyLevels {
                flex-direction: column;
                display: flex;
                align-items: center;
                text-align: center;
                font-family: verdana;
            }
            .menuformUserAcc {
                flex-direction: column;
                display: flex;
                align-items: center;
                text-align: center;
                font-family: verdana;
            }
            .menuformRestock {
                flex-direction: column;
                display: flex;
                align-items: center;
                text-align: center;
                font-family: verdana;
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
                padding: 10px;
                width: 200px;
                border-radius: 6px;
                cursor: pointer;
                background-color: #FEE135;
                font-family: verdana;
                font-weight: bold;
                outline: none;
                font-size: 15px;
                transition: all 0.3s ease-in-out;
            }
            .logoutAdminButton:hover {
                background-color: #362204;
                color: #ffffff;
            }
            .containter {
                text-align: center;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                width: 100%;
            }
            .container span{
                color: white;
                text-transform: uppercase;
                display: block;
            }
            .heading {
                font-size: 60px;
                font-weight: 700;
                letter-spacing: 8px;
                margin-bottom: 8px;
                position: relative;
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

        </style>

    </head>
    <body>
        <div class="header">
            <div class="logo">
                <img src="logo.png" style="width:300px;height:200px;">
            </div>
            <b class="heading">Welcome Admin!</b>
            <form class="logoutAdminForm" method="POST">
                <button class="logoutAdminButton" name="logout" type="submit">Logout</button>
            </form>
        </div>
        <form class="menuformHome" method="POST">
            <button style="background-color: #FEE135" type="home" name="home" class="menutab">Home</button>
        </form>
        <form class="menuformSupplyLevels" method="POST">
            <button class="menutab" style="background-color: #FEE135" name="supply" type="submit">Supply Levels</button>
        </form>
        <form class="menuformSummary" method="POST">
            <button style="background-color: #FEE135" type="summary" name="summary" class="menutab">Inventory Form</button>
        </form>
        <form class="menuformUserAcc" method="POST">
            <button style="background-color: #FEE135" type="submit" name="useracc" class="menutab">Manage User Accounts</button>
        </form> 
        <form class="menuformRestock" method="POST">
            <button style="background-color: #FEE135" type="submit" name="restock" class="menutab">Restock Form</button>
        </form>
    </body>
</html>