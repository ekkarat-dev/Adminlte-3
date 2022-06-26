<?php

session_start();
$host = "localhost";
$username = "root";
$password = "";
$database = "car";
$message = "";

try {
    $connect = new PDO("mysql:host=$host; dbname=$database", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST["login"])) {
        if (empty($_POST["email"]) || empty($_POST["password"])) {
            $message = '';
        } else {
            $query = "SELECT * FROM logins WHERE email = :email AND password = :password";
            $statement = $connect->prepare($query);
            $statement->execute(
                array(
                    'email' => $_POST["email"],
                    'password' => $_POST["password"]
                )
            );

            $count = $statement->rowCount();
            if ($count > 0) {
                $_SESSION["email"] = $_POST["email"];
                header("location:index.php");
            } else {
                $message = '<label> ข้อมูลไม่ถูกต้อง </label>';
            }
        }
    }
} catch (PDOException $error) {
    $message = $error->getMessage();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webslesson Tutorial | PHP Login Script using PDO</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <label class="text-danger"></label>
    <div class="title-bar">
        WELCOME
    </div>
    <div class="container" style="width:500px;">
        <?php
        if (isset($message)) {
            echo '<label class="text-danger">' . $message . '</label>';
        }
        ?>
    </div>
    <div class="info-bar">
        PHP Login Script using PDO
    </div>
    <div class="wrap">
        <form action="" method="post">
            <input type="email" for="email" name="email" class="form-control" placeholder="Email" required>
            <input type="password" for="password" name="password" class="form-control" placeholder="Password" required>
            <input type="submit" name="login" class="submit" value="Login">
        </form>
    </div>
</body>

</html>