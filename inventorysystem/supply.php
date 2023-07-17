<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function updateSupplyData($conn, $supplyData) {
    $setClause = '';
    $values = [];
    foreach ($supplyData as $key => $value) {
        if ($value === '') continue;

        if ($value === '0') {
            $setClause .= "$key = 0, ";
        } else {
            $setClause .= "$key = $key + ?, ";
            $values[] = $value;
        }
    }

    $setClause = rtrim($setClause, ', ');

    $query = "UPDATE supply SET $setClause";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        if (count($values) > 0) {
            $stmt->bind_param(str_repeat('i', count($values)), ...$values);
        }

        if ($stmt->execute()) {
            echo '<script>alert("Supply data updated successfully!");</script>';
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}



if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $supplyData = $_POST;
    updateSupplyData($conn, $supplyData);
}

$conn->close();
?>



<!DOCTYPE html>
<html>
    <head>
        <style>
            html, body {
                height: 100%;
                margin: 0;
                display: flex;
                font-family: verdana;
                background-image: url("bgsupply.jpeg.jpg");
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
            }
            .header {
                margin-top: 0px;
                position: absolute;
                align-items: center;
                display: flex;
                background-color: #FEE135;
                width: 100%;
                outline: auto;
            }
            .heading {
                font-size: 60px;
                color: #362204;
                margin-left: 50px;
                margin-top: 10px;
            }
            .logo {
                margin-top: 10px;
                top: 10px;
                left: 10px;
                margin-left: 10px;
            }
            .backForm {
                margin-top: 60px;
                margin-right: 30px;
                position: absolute;
                right: 10px;
                top: 10px;
            }
            .backButton {
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
            .supplyForm {
                margin: 0 auto;
                margin-top: 250px;
                transform: translateX(100%);
                background-color: rgba(254, 225, 53, 0.7);
                padding: 20px;
                border-radius: 12px;
                align-items: center;
                justify-content: center;
                display: flex;
                flex-direction: column;
                width: 600px;
                position: absolute;
                margin-bottom: 10px;
            }
            .itemNamesForm {
                margin-top: 10px;
                align-items: center;
                justify-content: center;
                font-size: 20px;
                font-family: verdana;
            }
            .itemText {
                margin-bottom: 10px;
                font-size: 20px;
                font-family: verdana;
            }
            .formLabel {
                margin-bottom: 10px;
                font-family: verdana;
            }
            .formInput {
                margin-bottom: 10px;
                padding: 10px;
                border-radius: 12px;
                outline: auto;
                width: 100%;
            }
            .submitBtn {
                margin-top: 10px;
                padding: 15px;
                background-color: white;
                border: #372204;
                border-radius: 6px;
                cursor: pointer;
                font-family: verdana;
                font-weight: bold;
                outline: auto;
                font-size: 15px;
                color: #362204;
            }
            .submitBtn:hover {
                background-color: #f0cc0e;
            }
            .backButton {
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
            .backButton:hover {
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
            <b class="heading">Supply Levels</b>
            <form class="backForm">
                <a href="adminwelcome.php"><button class="backButton" type="button">Back to Main Menu</button></a>
            </form>
        </div>
        <div class="supplyForm">
            <b class="itemText">Please Enter the number of items in stock:</b>
            <form class="itemNamesForm" method="POST">
                <div>
                    <label class="formLabel">Beef Pares:</label>
                    <input class="formInput" type="number" name="beef_pares">
                </div>
                <div>
                    <label class="formLabel">Gising Gising:</label>
                    <input class="formInput" type="number" name="gising_gising">
                </div>
                <div>
                    <label class="formLabel">Beef Caldereta:</label>
                    <input class="formInput" type="number" name="beef_caldereta">
                </div>
                <div>
                    <label class="formLabel">Beef Bistek Tagalog:</label>
                    <input class="formInput" type="number" name="beef_bistek_tagalog">
                </div>
                <div>
                    <label class="formLabel">Beef Salpicao:</label>
                    <input class="formInput" type="number" name="beef_salpicao">
                </div>
                <div>
                    <label class="formLabel">Puchero:</label>
                    <input class="formInput" type="number" name="puchero">
                </div>
                <div>
                    <label class="formLabel">Chopsuey:</label>
                    <input class="formInput" type="number" name="chopsuey">
                </div>
                <div>
                    <label class="formLabel">Roast Beef w/ Mushroom Gravy:</label>
                    <input class="formInput" type="number" name="roast_beef">
                </div>
                <div>
                    <label class="formLabel">Spaghetti Bolognese:</label>
                    <input class="formInput" type="number" name="spag_bolognese">
                </div>
                <div>
                    <label class="formLabel">Arroz ala Cubana:</label>
                    <input class="formInput" type="number" name="arroz_cubana">
                </div>
                <div>
                    <label class="formLabel">Beef Tapa:</label>
                    <input class="formInput" type="number" name="beef_tapa">
                </div>
                <div>
                    <label class="formLabel">Ropa Vieja:</label>
                    <input class="formInput" type="number" name="ropa_vieja">
                </div>
                <div>
                    <label class="formLabel">Kare-kare:</label>
                    <input class="formInput" type="number" name="kare_kare">
                </div>
                <div>
                    <label class="formLabel">Callos:</label>
                    <input class="formInput" type="number" name="callos">
                </div>
                <div>
                    <label class="formLabel">Bulalo:</label>
                    <input class="formInput" type="number" name="bulalo">
                </div>
                <div>
                    <label class="formLabel">Laing Spaghetti:</label>
                    <input class="formInput" type="number" name="laing_spag">
                </div>
                <div>
                    <label class="formLabel">Korean Beef Stew:</label>
                    <input class="formInput" type="number" name="kbeef_stew">
                </div>
                <div>
                    <label class="formLabel">Chicken Adobo:</label>
                    <input class="formInput" type="number" name="chicken_adobo">
                </div>
                <div>
                    <label class="formLabel">Ground Beef Curry:</label>
                    <input class="formInput" type="number" name="gbeef_curry">
                </div>
                <div>
                    <label class="formLabel">Nilagang Baka:</label>
                    <input class="formInput" type="number" name="nilagang_baka">
                </div>
                <div>
                    <label class="formLabel">Aglia Olio:</label>
                    <input class="formInput" type="number" name="aglia_olio">
                </div>
                <div>
                    <label class="formLabel">Beef Stroganoff:</label>
                    <input class="formInput" type="number" name="beef_stroganoff">
                </div>
                <div>
                    <label class="formLabel">Ginaataang Sitaw w/ Pork:</label>
                    <input class="formInput" type="number" name="ginataang_sitaw">
                </div>
                <div>
                    <label class="formLabel">Malai Kofta Curry:</label>
                    <input class="formInput" type="number" name="kofta_curry">
                </div>
                <div>
                    <label class="formLabel">Fettuccine Alfredo:</label>
                    <input class="formInput" type="number" name="fettuccine_alfredo">
                </div>
                <div>
                    <label class="formLabel">Afritada:</label>
                    <input class="formInput" type="number" name="afritada">
                </div>
                <button class="submitBtn" type="submit" name="submit">Update Supply Levels</button>
            </form>
        </div>
    </body>
</html>
