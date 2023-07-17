<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventory";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    
    $sql = "INSERT INTO restockform (date, product_id, product_name, quantity) 
            VALUES ('$date', '$product_id', '$product_name', '$quantity')";
    
    if (mysqli_query($conn, $sql)) {
        echo "Restock form data saved successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM restockform ORDER BY date ASC";
$result = mysqli_query($conn, $sql);

mysqli_close($conn);

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
                background-image: url("restock.jpg");
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;
                font-family: verdana;
                align-items: center;
                justify-content: flex-start;
            }
            .header {
                margin-top: 0px;
                position: absolute;
                align-items: center;
                display: flex;
                background-color: #FEE135;
                width: 100%;
                height: 215px;
                outline: auto;
            }
            .heading {
                font-size: 60px;
                color: #362204;
                margin-left: 50px;
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
            .logo {
                margin-top: 10px;
                top: 10px;
                left: 10px;
                margin-left: 10px;
            }
            .restockForm {
                margin-top: 300px;
                align-items: center;
                justify-content: center;
                color: #362204;
            }
            .restockFormText {
                font-size: 20px;
                font-family: verdana;
                font-weight: bold;
                margin-bottom: 10px;
            }
            .formInput {
                margin-bottom: 20px;
                width: 300px;
                padding: 10px;
                border-radius: 6px;
                border: 1px solid #362204;
                font-size: 15px;
                outline: none;
                font-family: verdana;
            }
            .submitBtn {
                padding: 10px 20px;
                border-radius: 6px;
                cursor: pointer;
                background-color: #FEE135;
                font-family: verdana;
                font-weight: bold;
                outline: none;
                font-size: 15px;
                transition: all 0.3s ease-in-out;
            }
            .submitBtn:hover {
                background-color: #362204;
                color: #ffffff;
            }
            .dataTable {
                margin-top: 50px;
                width: 800px;
                background-color: rgba(254, 225, 53, 0.7);
                padding: 20px;
                border-radius: 6px;
                color: #362204;
                overflow-x: auto;
            }
            .tableHeading {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 10px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                padding: 8px;
                text-align: left;
                border-bottom: 1px solid #362204;
            }
            .printButton {
            margin-top: 20px;
            text-align: center;
            }

            .printBtn {
                padding: 10px 20px;
                border-radius: 6px;
                cursor: pointer;
                background-color: #FEE135;
                font-family: Arial, sans-serif;
                font-weight: bold;
                outline: auto;
                font-size: 15px;
                transition: all 0.3s ease-in-out;
                border: none;
            }

            .printBtn:hover {
                background-color: #362204;
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="logo">
                <img src="logo.png" style="width: 300px; height: 200px;">
            </div>
            <b class="heading">Restock Form</b>
            <form class="backForm">
                <a href="adminwelcome.php">
                    <button class="backButton" type="button">Back to Main Menu</button>
                </a>
            </form>
        </div>
        <div class="restockForm">
            <div class="restockFormText">Insert Items to be restocked:</div>
            <form method="post">
                <input class="formInput" type="date" name="date" required>
                <input class="formInput" type="text" name="product_id" placeholder="Product ID" required>
                <select class="formInput" type="text" name="product_name" placeholder="Product Name" required>
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
                <input class="formInput" type="number" name="quantity" placeholder="Quantity" required>
                <button class="submitBtn" type="submit">Save</button>
            </form>
        </div>
        <div class="dataTable">
            <div class="tableHeading">Restock Form Data:</div>
            <table>
                <tr>
                    <th>Date</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Quantity to Restock</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['product_id'] . "</td>";
                    echo "<td>" . $row['product_name'] . "</td>";
                    echo "<td>" . $row['quantity'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <div class="printButton">
                <button class="printBtn" onclick="printTable()">Print</button>
            </div>
        </div>

    </body>
    <script>
        function printTable() {
            var printWindow = window.open('', '_blank');

            var htmlContent = '<html><head><title>Print Table</title>';
        htmlContent += '<style>';
        htmlContent += 'body { font-family: Arial, sans-serif;}';
        htmlContent += 'table { border-collapse: collapse; width: 100%; margin-top: 20px; }';
        htmlContent += 'th, td { padding: 10px; border-bottom: 1px solid #362204; text-align: left; }';
        htmlContent += '</style>';
        htmlContent += '</head><body>';
        htmlContent += '<table>' + document.querySelector('.dataTable table').innerHTML + '</table>';
        htmlContent += '</body></html>';

            printWindow.document.open();
            printWindow.document.write(htmlContent);
            printWindow.document.close();


            printWindow.print();
        }
    </script>
</html>
