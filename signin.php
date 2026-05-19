<?php

session_start();

$pdo = new PDO(
    'mysql:host=localhost;port:33060;dbname=opslag',
    'bit_academy',
    'bit_academy'
);
$pdo->exec("USE opslag");
$stmt = $pdo->query("SELECT * FROM gebruikers");
$gebruikers = $stmt->fetchAll();


foreach ($gebruikers as $gebruiker) {
        if ($_COOKIE["username"] == $gebruiker['username'] && $_COOKIE["password"] == $gebruiker['password']) {
            header("Location: index.php");
            exit;
        }
    }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signin</title>
    
</head>

<body>
    <form method='post'>
        <div class="centering">
            <h1>Ticket Support System</h1>
            <div class="Signin">
                <input type="text" name="username" placeholder="Username" class="text"><br><br>
                <input type="password" name="password" placeholder="Password" class="text"><br><br><br>
                <button class="button" type="submit" name="button">Signin</button>
            </div>
        </div>
    </form>
    <a href="login.php" class="centering">Already have an account</a>
    <?php 
    if (isset($_COOKIE["msg_wrong"])) {
        echo "<a class='wrongmsg'>Username already in use!</a>";
    } ?>
</body>
<footer>
    <p class="TSS">TSS</p>
</footer>

</html>
<?php
if (isset($_POST['button'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    foreach ($gebruikers as $gebruiker) {
        if ($username == $gebruiker['username']) {
            $username_exist = true;
            setcookie("msg_wrong", "true", time() + 1);
            header("Location: signin.php");
            exit;
        }
    }
    if (!isset($username_exist)) {
        if ($username != "") {
            if ($password != "") {
                $pdo = new PDO("mysql:host=localhost;dbname=opslag", "bit_academy", "bit_academy");

                $pdo->exec("INSERT INTO gebruikers (username, password) VALUES ('$username', '$password')");

                setcookie("username", $username, time() + 604800);
                setcookie("password", $password, time() + 604800);
                header("Location: index.php");
            }        
        }
    }
}