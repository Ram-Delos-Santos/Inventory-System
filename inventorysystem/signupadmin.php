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

        $query = "SELECT * FROM admin WHERE username = '$username'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo '<script>alert("Username already exists. Please choose another username.");</script>';
        } else {
            $query = "INSERT INTO admin (username, password) VALUES ('$username', '$password')";
            if (mysqli_query($conn, $query)) {
                header("Location: adminlogin.php");
                exit();
            } else {
                $error = "Error: " . $query . "<br>" . mysqli_error($conn);
            }
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
            .signup-form {
                background-color: rgba(254, 225, 53, 0.7);
                border-radius: 12px;
                margin-top: 250px;
                display: flex;
                flex-direction: column;
                align-items: center;
                padding: 60px;
            }
            .signup-input {
                padding: 15px;
                width: 500px;
                border-radius: 12px;
            }
            .container{
                height: 100vh;
                display: flex;
                justify-content: center;
                align-items: center;
                background-color: #362204;
            }
            .signup-input {
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
            .signupButton{
                margin-top: 10px;
                padding: 10px;
                width: 100px;
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.3s ease-in-out;
            }
            .signupButton:hover,
            .backButton:hover {
                background-color: #362204;
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class="header">
            <b class="heading">Sign Up a New Account</b>
        </div>
        <form class="signup-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input class="signup-input" type="text" name="username" placeholder="Username" required><br><br>
            <input class="signup-input" type="password" name="password" placeholder="Password" required><br><br>
            <button class="signupButton" type="submit">Sign Up</button></a>
        </form>
        <form class="backForm">
            <a href="index.php"><button class="backButton" type="button">Back</button></a>
        </form>
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
    </body>
</html>