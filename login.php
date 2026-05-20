<?php

session_start();

include 'database.php';

$pdo->exec("USE opslag");
$stmt = $pdo->query("SELECT * FROM gebruikers");
$gebruikers = $stmt->fetchAll();


foreach ($gebruikers as $gebruiker) {
        if (isset($_COOKIE['username'])) {
            if ($_COOKIE["username"] == $gebruiker['username'] && $_COOKIE["password"] == $gebruiker['password']) {
                header("Location: index.php");
                exit;
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
</head>

<body>
    <form method='post'>
        <div class="centering">
            <h1>Ticket Support System</h1>
            <div class="login">
                <input type="text" name="username" placeholder="Username" class="text"><br><br>
                <input type="password" name="password" placeholder="Password" class="text"><br><br><br>
                <button class="button" type="submit" name="button">Login</button>
            </div>
        </div>
    </form>
    <a href="signin.php" class="centering">Create an account</a>
    <?php
    if (isset($_COOKIE["msg_wrong"])) {
        echo "<a class='wrongmsg'>Password or Username is wrong!</a>";
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
        if ($username == $gebruiker['username'] && $password == $gebruiker['password']) {
            $logged_in = true;
            setcookie("username", $username, time() + 604800);
            setcookie("password", $password, time() + 604800);
            header("Location: index.php");
            exit;
        }
    }
    if (!isset($logged_in)) {
        setcookie("msg_wrong", "true", time() + 1);
        header("Location: login.php");
    }
}
