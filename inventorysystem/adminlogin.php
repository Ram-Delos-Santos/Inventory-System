<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (empty($username) || empty($password)) {
        echo '<script>alert("Please fill in all the fields.");</script>';
    } else {
        $conn = mysqli_connect("localhost", "root", "", "inventory");

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $query = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            header("Location: adminwelcome.php");
            exit();
        } else {
            echo '<script>alert("Invalid username or password.");</script>';
        }

        mysqli_close($conn);
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
                background-image: url('login.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-attachment: fixed;     
            }
            .header {
                margin-top: 0px;
                display: flex;
                align-items: center;
                justify-content: center;
                position: absolute;
                background-color: #FEE135;
                width: 100%;
            }
            .heading {
                margin-top: 50px;
                margin-bottom: 50px;
                font-size: 60px;
                font-style: verdana;
                color: #362204;
            }
            .backForm {
                margin-top: 60px;
                margin-right: 30px;
                position: absolute;
                bottom: 10px;
                right: 10px;
            }
            .login-form {
                background-color: rgba(254, 225, 53, 0.7);
                border-radius: 12px;
                margin-top: 250px;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 60px;
            }
            .login-input {
                padding: 15px;
                width: 500px;
                border-radius: 12px;
            }
            .backButton {
                margin-top: 10px;
                padding: 10px;
                width: 200px;
                font-family: verdana;
                font-weight: bold;
                font-size: 15px;
                background-color: #FEE135;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }
            .container{
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #362204;
            }
            .login-input {
                font-size: 2rem;
                padding: 18px 35px;
                background: transparent;
                border: 2px solid #fff;
                border-radius: 10px;
                flex-direction: column;
            }
            ::placeholder{
                color: #fff;
                font-size: 2rem;
            }

            .login-button,
            .signupButton{
                margin-top: 10px;
                padding: 10px;
                width: 100px;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }
            .login-button:hover,
            .signupButton:hover,
            .backButton:hover {
                background-color: #362204;
                color: #ffffff;
            }

            .backButton:hover {
                background-color: #362204;
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <b class="heading">Admin Login</b>
        </div>
        <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input class="login-input" type="text" name="username" placeholder="Username" required><br><br>
            <input class="login-input" type="password" name="password" placeholder="Password" required><br><br>
            <button class="login-button" type="submit" value="Login">Login</button>
            <a href="signupadmin.php"><button class="signupButton" type="button">Sign Up</button></a>
        </form>
        <form class="backForm">
            <a href="index.php"><button class="backButton" type="button">Back</button></a>
        </form>
    </body>
</html>
