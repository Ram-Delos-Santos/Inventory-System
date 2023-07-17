<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "inventory";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function updateSupply($conn, $productName, $orderQuantity) {
    $columnName = strtolower(str_replace(" ", "_", $productName));

    $updateQuery = "UPDATE `supply` SET `$columnName` = `$columnName` - $orderQuantity WHERE 1";
    $conn->query($updateQuery);
}

function computeInStock($conn, $productName) {
    $columnName = strtolower(str_replace(" ", "_", $productName));

    $query = "SELECT `$columnName` AS `supply_quantity`,
              IFNULL((SELECT SUM(`quantity`) FROM `orders` WHERE `product_name` = '$productName'), 0) AS `total_orders_quantity`
              FROM `supply`
              LIMIT 1";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $supplyQuantity = $row['supply_quantity'];
        $totalOrdersQuantity = $row['total_orders_quantity'];
        $inStock = $supplyQuantity - $totalOrdersQuantity;
        return max(0, $inStock);
    } else {
        return "N/A";
    }
}

function computeStatus($inStock) {
    if ($inStock === "N/A") {
        return "N/A";
    } elseif ($inStock <= 0) {
        return "Out of Stock";
    } elseif ($inStock <= 5) {
        return "Critical";
    } else {
        return "In Stock";
    }
}

function printInventoryTable($conn) {
    $productColumns = array(
        "beef_pares",
        "gising_gising",
        "beef_caldereta",
        "beef_bistek_tagalog",
        "beef_salpicao",
        "puchero",
        "chopsuey",
        "roast_beef",
        "spag_bolognese",
        "arroz_cubana",
        "beef_tapa",
        "ropa_vieja",
        "kare_kare",
        "callos",
        "bulalo",
        "laing_spag",
        "kbeef_stew",
        "chicken_adobo",
        "gbeef_curry",
        "nilagang_baka",
        "aglia_olio",
        "beef_stroganoff",
        "ginataang_sitaw",
        "kofta_curry",
        "fettuccine_alfredo",
        "afritada"
    );

    echo '<table>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>In Stock</th>
                <th>Status</th>
            </tr>';

    foreach ($productColumns as $column) {
        $productName = ucwords(str_replace("_", " ", $column));

        $inStock = computeInStock($conn, $column);
        $status = computeStatus($inStock);

        echo '<tr>
                <td>' . $column . '</td>
                <td>' . $productName . '</td>
                <td>' . $inStock . '</td>
                <td>' . $status . '</td>
            </tr>';
    }

    echo '</table>';
}


$newOrderQuery = "SELECT COUNT(*) AS `new_orders_count` FROM `orders` WHERE `status` = 'new'";
$newOrderResult = $conn->query($newOrderQuery);
$newOrdersCount = $newOrderResult->fetch_assoc()['new_orders_count'];

if ($newOrdersCount > 0) {
    $newOrderQuery = "SELECT `product_name`, `quantity` FROM `orders` WHERE `status` = 'new'";
    $newOrdersResult = $conn->query($newOrderQuery);

    if ($newOrdersResult->num_rows > 0) {
        while ($orderRow = $newOrdersResult->fetch_assoc()) {
            $productName = $orderRow['product_name'];
            $orderQuantity = $orderRow['quantity'];

            updateSupply($conn, $productName, $orderQuantity);
        }
    }

    $updateStatusQuery = "UPDATE `orders` SET `status` = 'processed' WHERE `status` = 'new'";
    $conn->query($updateStatusQuery);
}

?>


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
            background-image: url("https://i.pinimg.com/originals/d3/6d/46/d36d462db827833805497d9ea78a1343.jpg");
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
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
            margin-left: 10px;
        }
        .backForm {
            margin-top: 60px;
            margin-right: 30px;
            position: absolute;
            right: 10px;
            top: 10px;
        }
        .summaryChart {
            margin: 300px auto;
            color: #362204;
            padding: 60px;
            border-radius: 12px;
            width: 1000px;
            margin-left: 400px;
            justify-content: center;
        }
        .summaryChart table {
            width: 100%;
            background-color: rgba(254, 225, 53, 0.7);
            padding: 60px;
            border-radius: 12px;
            color: #362204;
            height: max-content;
        }
        .summaryChart th {
            background-color: #FEE135;
            padding: 10px;
        }
        .summaryChart td {
            padding: 5px;
            text-align: center;
        }
        .clearForm {
            margin-top: auto; 
            margin-right: 50px; 
            margin-bottom: 10px; 
            justify-content: flex-end; 
            flex-direction: column;
            text-align: right;
            position: absolute;
            bottom: 0; 
            right: 0;
        }
        .addMoreForm {
            margin-top: auto; 
            margin-left: 10px; 
            margin-bottom: 20px; 
            justify-content: flex-start; 
            flex-direction: column;
            text-align: right;
            position: relative;
            bottom: 50px;
            right: 20px;
        }
        .container{
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #362204;
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

        .addMoreButton {
            padding: 15px;
            background-color: #FEE135;
            border: #372204;
            border-radius: 6px;
            cursor: pointer;
            font-family: verdana;
            font-weight: bold;
            outline: auto;
            font-size: 15px;
            color: #362204;
            transition: all 0.3s ease-in-out;
        }
        .addMoreButton:hover {
            background-color: #362204;
            color: #ffffff;
        }

        .clearButton {
            padding: 15px;
            background-color: #FEE135;
            border: #372204;
            border-radius: 6px;
            cursor: pointer;
            font-family: verdana;
            font-weight: bold;
            outline: auto;
            font-size: 15px;
            color: #362204;
            transition: all 0.3s ease-in-out;
        }
        .clearButton:hover {
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
        <b class="heading">Inventory Form</b>
        <form class="backForm" action="adminwelcome.php">
            <button class="backButton" type="submit">Back to Main Menu</button>
        </form>
    </div>
    <div class="summaryChart">
        <?php printInventoryTable($conn); ?>
        <form class="addMoreForm">
        <a href="supply.php"><button class="addMoreButton" type="button">Update Supply Levels</button></a>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
