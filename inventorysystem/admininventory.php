<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save"])) {
    
    $date = $_POST["dateInput"] ?? '';
    $productId = $_POST["productIdInput"] ?? '';
    $productName = $_POST["productInput"] ?? '';
    $quantity = $_POST["quantityInput"] ?? '';

    if (empty($date) || empty($productId) || empty($productName) || empty($quantity)) {
        echo '<script>alert("Please fill in all the fields.");</script>';
    } else {
        $conn = mysqli_connect("localhost", "root", "", "inventory");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "INSERT INTO inventoryform (date, product_id, product_name, quantity) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $date, $productId, $productName, $quantity);

        if (mysqli_stmt_execute($stmt)) {
            echo '<script>alert("Data saved successfully!");</script>';
        } else {
            $error = "Error: " . $query . "<br>" . mysqli_error($conn);
            echo $error;
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel = "stylesheet" href = "savebutton.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
            font-family: verdana;
            background-image: url("admininventory.jpg");
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        .backForm {
            margin-top: 60px;
            margin-right: 30px;
            position: absolute;
            right: 10px;
            top: 10px;
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
        }
        .logo {
            margin-top: 10px;
            top: 10px;
            left: 10px;
            margin-left: 10px;
        }
        .fillup {
            margin-top: 300px;
            text-align: left;
            margin-left: 20px;
        }
        .form-row {
            display: flex;
            flex-direction: row;
            justify-content: flex-start;
            margin-bottom: 10px;
            margin-right: 10px;
        }
        .input-field {
            margin-top: 20px;
            padding: 30px;
            width: 500px;
            border-radius: 12px;
            outline: auto;
            margin-right: 10px;            
        }
        .container{
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #362204;
        }
        .saveButton {
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
            transition: all;
        }
        .saveButton:hover {
            background-color: #f0cc0e;
            color: #050000;
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
        <b class="heading">Inventory</b>
        <form class="backForm">
            <a href="adminwelcome.php"><button class="backButton" type="button">Back to Main Menu</button></a>
        </form>
    </div>
    <div class="fillup">
        <form method="POST">
            <div class="form-row">
                <input type="text" name="dateInput" class="input-field" placeholder="Date" required>
            </div>
            <div class="form-row">
                <input type="text" name="productIdInput" class="input-field" placeholder="Product ID" required>
                <select name="productInput" class="input-field" style="cursor:pointer" required>
                    <option>Beef Pares</option>
                    <option>Gising Gising</option>
                    <option>Beef Caldereta</option>
                    <option>Beef Bistek Tagalog</option>
                    <option>Beef Salpicao</option>
                    <option>Puchero</option>
                    <option>Chopsuey</option>
                    <option>Roast Beef with Mushroom Gravy</option>
                    <option>Spaghetti Bolognese</option>
                    <option>Arroz ala Cubana</option>
                    <option>Beef Tapa</option>
                    <option>Ropa Vieja</option>
                    <option>Kare-kare</option>
                    <option>Callos</option>
                    <option>Bulalo</option>
                    <option>Laing Spaghetti</option>
                    <option>Korean Beef Stew</option>
                    <option>Chicken Adobo</option>
                    <option>Ground Beef Curry</option>
                    <option>Nilagang Baka</option>
                    <option>Aglia Olio</option>
                    <option>Beef Stroganoff</option>
                    <option>Ginataang Sitaw with Pork</option>
                    <option>Malai Kofta Curry</option>
                    <option>Fettuccine Alfredo</option>
                    <option>Afritada</option>
                </select>
            </div>
            <div class="form-row">
                <input type="number" name="quantityInput" class="input-field" placeholder="Product Quantity">
            </div>
            <form class="saveForm">
            <button class="saveButton" type="submit" name="save">Add to Inventory</button>
        </form>
    </div>
</body>
</html>