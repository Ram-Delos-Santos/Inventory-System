<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "inventory";

    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    function displayUserAccounts($conn) {
        $adminQuery = mysqli_query($conn, "SELECT username, password, 'admin' as source FROM admin");
        $adminData = mysqli_fetch_all($adminQuery, MYSQLI_ASSOC);

        $managerQuery = mysqli_query($conn, "SELECT username, password, 'manager' as source FROM manager");
        $managerData = mysqli_fetch_all($managerQuery, MYSQLI_ASSOC);

        $userData = array_merge($adminData, $managerData);

        function getPosition($source){
            if ($source === 'admin') {
                return 'Admin';
            } elseif ($source === 'manager') {
                return 'Manager';
            } else {
                return 'Unknown';
            }
        }

        echo '<table>';
        echo '<tr>';
        echo '<th>Username</th>';
        echo '<th>Position</th>';
        echo '<th>Password</th>';
        echo '<th>Action</th>';
        echo '</tr>';

        foreach ($userData as $user) {
            echo '<tr>';
            echo '<td>' . $user['username'] . '</td>';
            echo '<td>' . getPosition($user['source']) . '</td>';
            echo '<td>' . $user['password'] . '</td>';
            echo '<td>';
            echo '<form method="post" action="">';
            echo '<input type="hidden" name="username" value="' . $user['username'] . '">';
            echo '<input type="hidden" name="source" value="' . $user['source'] . '">';
            echo '<input class="deleteBtn" type="submit" name="delete" value="Delete">';
            echo '</form>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }

    if (isset($_POST['delete'])) {
        $username = $_POST['username'];
        $source = $_POST['source'];
        deleteFromDatabase($conn, $source, $username);
    }

    function deleteFromDatabase($conn, $source, $username) {
        $table = ($source === 'admin') ? 'admin' : 'manager';
        $deleteQuery = "DELETE FROM $table WHERE username = '$username'";
        $result = mysqli_query($conn, $deleteQuery);

        if ($result) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            html, body {
                height: 100%;
                margin: 0px;
                display: flex;
                flex-direction: column;
                background-image: url("useracc.jpg");
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
            .logo {
                margin-top: 10px;
                top: 10px;
                left: 10px;
                margin-left: 10px;
            }
            .userAccForm {
                margin: 300px auto;
                color: #362204;
                padding: 60px;
                border-radius: 12px;
                width: 1000px;
                margin-left: 100px;
                justify-content: center;
            }
            table {
                width: 100%;
                background-color: rgba(254, 225, 53, 0.7);
                padding: 60px;
                border-radius: 12px;
                color: #362204;
            }

            th{
                background-color: #FEE135;
                padding: 10px;
            }

            td {
                padding: 5px;
                text-align: center;
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
            .deleteBtn {
                padding: 10px;
                font-size: 15px;
                width: 100px;
                border-radius: 12px;
                background-color: #362204;
                color: white;
                font-weight: bold;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }
            .deleteBtn:hover {
                background-color: #FEE135;
                color: #362204;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <div class="logo">
                <img src="logo.png" style="width:300px;height:200px;">
            </div>
            <b class="heading">Manage User Accounts</b>
            <form class="backForm">
                <a href="adminwelcome.php"><button class="backButton" type="button">Back to Main Menu</button></a>
            </form>
        </div>
        <form class="userAccForm">
            <?php
                displayUserAccounts($conn);
            ?>
        </form>
    </body>
</html>

<?php
    mysqli_close($conn);
?>
