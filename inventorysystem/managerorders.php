<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function processOrder($conn) {
    $sql = "DELETE FROM confirmsave";
    
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        echo "<script>alert('Order has been processed');</script>";
    } else {
        echo "<script>alert('Failed to process the order');</script>";
    }
}

if (isset($_POST['confirm-order'])) {
    processOrder($conn);
}

function checkProductAvailability($productName, $conn) {
    $columnName = str_replace(' ', '_', $productName);
    $query = "SELECT `$columnName` FROM supply"; 
    $result = mysqli_query($conn, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $productValue = $row[$columnName];

        foreach ($_POST['quantity'] as $quantity) {
            if ($quantity > $productValue) {
                echo '<script>alert("Sorry, Product is unavailable at the moment!");</script>';
                return false;
            }
        }

        if ($productValue <= 0) {
            echo '<script>alert("Sorry, Product is unavailable at the moment!");</script>';
            return false;
        }
    } else {
        echo 'Error executing the query: ' . mysqli_error($conn);
        return false;
    }

    return true;
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
    $option = $_POST["option"];
    $products = $_POST["product"];
    $quantities = $_POST["quantity"];
    $productID = $_POST["product-id"];

    $canSaveOrder = true;
    foreach ($products as $product) {
        if (!checkProductAvailability($product, $conn)) {
            $canSaveOrder = false;
            break;
        }
    }

    if ($canSaveOrder) {
        $oSql = "INSERT INTO orders (product_option, product_id, product_name, quantity) VALUES (?, ?, ?, ?)";
        $iSql = "INSERT INTO confirmsave (product_option, product_id, product_name, quantity) VALUES (?, ?, ?, ?)";
        $oStmt = $conn->prepare($oSql);
        $iStmt = $conn->prepare($iSql);

        for ($i = 0; $i < count($products); $i++) {
            $product = $products[$i];
            $quantity = $quantities[$i];

            if (!empty($quantity)) {
                $oStmt->bind_param("sssi", $option, $productID, $product, $quantity);
                $oStmt->execute();

                $iStmt->bind_param("sssi", $option, $productID, $product, $quantity);
                $iStmt->execute();
            }
        }

        $oStmt->close();
        $iStmt->close();
    }
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
            flex-direction: column;
            font-family: verdana;
            background-image: url("orders.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-attachment: fixed;
            background-color: transparent;
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
            font-family: verdana;
            font-size: 60px;
            color: #362204;
            margin-left: 50px;
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
            transition: all 0.3s ease-in-out;
        }
        .backButton:hover {
            background-color: #362204;
            color: #ffffff;
        }

        .orderForm {
            margin-top: 300px;
            width: 1500px;
            text-align: left;
            background-color: rgba(254, 225, 53, 0.7);
            border-radius: 12px;
            padding: 60px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-left: 150px;
            flex: content;
        }

        .productButton {
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
            background-color: rgba(255, 255, 255, 0.7); 
            outline: none;
            border: none;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .productButton:hover {
            transform: scale(1.05);
        }

        .productButton img {
            margin-bottom: 10px;
            width: 200px;
            height: 200px;
        }
        .productButton span {
            display: block;
            font-weight: bold;
            text-align: center;
        }
        .productButton  {
            background-color: rgba(255, 255, 255, 0.7); 
            outline: none;
            border: none;
        }       
        .quantityInput {
            width: 200px;
            height: 50px;
            text-align: left;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
        }
        .idInput {
            width: 200px;
            height: 50px;
            text-align: left;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 20px;
            border: 1px solid #ccc;
            border-radius: 12px;
        }
        .submitButton {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
            background-color: #FEE135;
            border: none;
            outline: auto;
            transition: background-color 0.3s ease;
        }
        .submitButton:hover {
            background-color: #362204;
            color: #ffffff;
        }
        .saveButton {
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 12px;
            cursor: pointer;
            background-color: #FEE135;
            border: none;
            outline: auto;
            transition: background-color 0.3s ease;
            flex-direction: row;
        }
        .saveButton:hover {
            background-color: #362204;
            color: #ffffff;
        }
        table {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.8);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th {
            background-color: #FEE135;
            color: #362204;
            padding: 15px;
            font-size: 18px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        td {
            padding: 12px;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.5);
        }

        .no-orders {
            font-size: 18px;
            text-align: center;
            padding: 20px;
            color: #888;
        }
        label {
            display: inline-block;
            margin-bottom: 10px;
            font-weight: bold;
            font-size: 16px;
        }

        label img {
            display: block;
            margin-bottom: 10px;
            width: 200px;
            height: 200px;
            border-radius: 12px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label span {
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="logo.png" style="width:300px;height:200px;">
        </div>
        <b class="heading">Orders</b>
        <form class="backForm">
            <a href="managerwelcome.php"><button class="backButton" type="button">Back to Main Menu</button></a>
        </form>
    </div>
    <div class="orderForm">
        <h2>Create Order</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="option">Order Option:</label><br>
            <input type="radio" id="dine-in" name="option" value="Dine-in">
            <label for="dine-in">Dine-in</label>
            <input type="radio" id="delivery" name="option" value="Delivery">
            <label for="delivery">Delivery</label><br><br>

            <label for="product-id">Product ID:</label><br>
            <input class="idInput" type="text" id="product-id" name="product-id" placeholder="Enter Product ID"><br><br>

            <label for="product">Select Product(s):</label><br>

            <div class="productButton">
                <input type="checkbox" name="product[]" value="Beef Pares">
                <label for="beef_pares">
                    <img src="beefPares.png" alt="Beef Pares">
                    <span>Beef Pares</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Gising Gising">
                <label for="gising_gising">
                    <img src="gisinggising.png" alt="Gising Gising">
                    <span>Gising Gising</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Beef Caldereta">
                <label for="beef_caldereta">
                    <img src="caldereta.png" alt="Beef Caldereta">
                    <span>Beef Caldereta</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Beef Bistek Tagalog">
                <label for="beef_bistek_tagalog">
                    <img src="bistek.png" alt="Beef Bistek Tagalog">
                    <span>Beef Bistek Tagalog</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Beef Salpicao">
                <label for="beef_salpicao">
                    <img src="salpicao.png" alt="Beef Salpicao">
                    <span>Beef Salpicao</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Puchero">
                <label for="puchero">
                    <img src="puchero.png" alt="Puchero">
                    <span>Puchero</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Chopsuey">
                <label for="chopsuey">
                    <img src="chopsuey.png" alt="Chopsuey">
                    <span>Chopsuey</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Roast Beef">
                <label for="roast_beef">
                    <img src="roastbeef.png" alt="Roast Beef with Mushroom Gravy">
                    <span>Roast Beef with Mushroom Gravy</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Spag Bolognese">
                <label for="spag_bolognese">
                    <img src="spagbo.png" alt="Spaghetti Bolognese">
                    <span>Spaghetti Bolognese</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Arroz Cubana">
                <label for="arroz_cubana">
                    <img src="arrozcubana.png" alt="Arroz ala Cubana">
                    <span>Arroz ala Cubana</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Beef Tapa">
                <label for="beef_tapa">
                    <img src="beeftapa.png" alt="Beef Tapa">
                    <span>Beef Tapa</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Ropa Vieja">
                <label for="ropa_vieja">
                    <img src="ropavieja.png" alt="Ropa Vieja">
                    <span>Ropa Vieja</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Kare Kare">
                <label for="kare_kare">
                    <img src="karekare.png" alt="Kare-kare">
                    <span>Kare-kare</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Callos">
                <label for="callos">
                    <img src="callos.png" alt="Callos">
                    <span>Callos</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Bulalo">
                <label for="bulalo">
                    <img src="bulalo.png" alt="Bulalo">
                    <span>Bulalo</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Laing Spag">
                <label for="laing_spaghetti">
                    <img src="laingspag.png" alt="Laing Spaghetti">
                    <span>Laing Spaghetti</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Kbeef Stew">
                <label for="kbeef_stew">
                    <img src="kbeefstew.png" alt="Korean Beef Stew">
                    <span>Korean Beef Stew</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Chicken Adobo">
                <label for="chicken_adobo">
                    <img src="chickenadobo.png" alt="Chicken Adobo">
                    <span>Chicken Adobo</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="GBeef Curry">
                <label for="gbeef_curry">
                    <img src="gbeefcurry.png.png" alt="Ground Beef Curry">
                    <span>Ground Beef Curry</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Nilagang Baka">
                <label for="nilagang_baka">
                    <img src="beefnilaga.png" alt="Nilagang Baka">
                    <span>Nilagang Baka</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Aglia Olio">
                <label for="aglia_olio">
                    <img src="agliaolio.png" alt="Aglia Olio">
                    <span>Aglia Olio</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Beef Stroganoff">
                <label for="beef+stroganoff">
                    <img src="beefstroganoff.png" alt="Beef Stroganoff">
                    <span>Beef Stroganoff</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Ginataang Sitaw">
                <label for="ginataang_sitaw">
                    <img src="ginataangsitaw.png" alt="Ginataang Sitaw with Pork">
                    <span>Ginataang Sitaw with Pork</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Kofta Curry">
                <label for="kofta_curry">
                    <img src="malaikofta.png" alt="Malai Kofta Curry">
                    <span>Malai Kofta Curry</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Fettuccine Alfredo">
                <label for="fettuccine_alfredo">
                    <img src="fettuccinealfredo.png" alt="Fettuccine Alfredo">
                    <span>Fettuccine Alfredo</span>
                </label>
            </div>
            <div class="productButton">
                <input type="checkbox" name="product[]" value="Afritada">
                <label for="afritada">
                    <img src="afritada.png" alt="Afritada">
                    <span>Afritada</span>
                </label>
            </div>

            <br>
            <label for="quantity">Quantity:</label><br>
            <input type="number" class="quantityInput" id="quantity" name="quantity[]" min="1">
            <button class="saveButton" name="save">Save</button>
            <?php

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "inventory";

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT product_option, product_id, product_name, quantity FROM confirmsave";
            $result = $conn->query($sql);

            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Option</th>";
            echo "<th>Product ID</th>";
            echo "<th>Product</th>";
            echo "<th>Quantity</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["product_option"] . "</td>";
                    echo "<td>" . $row["product_id"] . "</td>";
                    echo "<td>" . $row["product_name"] . "</td>";
                    echo "<td>" . $row["quantity"] . "</td>";
                    echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No orders saved yet.</td></tr>";
        }

        echo "</tbody>";
        echo "</table>";

        $conn->close();
        ?>

            <br><br>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button class="submitButton" type="submit" name="confirm-order">Confirm Order</button>
        </form>    
    </form>
    </div>
</body>
</html>