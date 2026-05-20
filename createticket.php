<?php

session_start();

include 'database.php';

$pdo->exec("USE opslag");
$stmt = $pdo->query("SELECT * FROM gebruikers");
$gebruikers = $stmt->fetchAll();

foreach ($gebruikers as $gebruiker) {
    if ($_SESSION["username"] == $gebruiker['username'] && $_SESSION["password"] == $gebruiker['password']) {
        $logged_in = true;
    }
}
if (!isset($logged_in)) {
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
    header("Location: front.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <table class="head">
        <tr>
            <form method="POST">
                <td><?= $_SESSION['username'] ?></td>
                <td><button class="back" name="back">Go Back</button></td>
            </form>
        </tr>
    </table>

</head>

<body>
    <form method='post'>
        <div class="createticket">

            <label>Title</label>
            <input class="titletext" type="text" name="title">

            <label>Description</label>
            <textarea class="descriptiontext" name="description"></textarea>

            <button class="postbutton" name="post">Post</button>
        </div>
    </form>
    <?php 
    if (isset($_COOKIE['msg_wrong'])) {
        echo "<a class='wrongmsg'>You have to fill both</a>";
    }
    ?>
</body>
<footer>
    <p class="TSS">TSS</p>
</footer>

</html>

<?php
if (isset($_POST['back'])) {
    header("location: index.php");
    exit;
}

if (isset($_POST['post'])) {

    $username = $_SESSION['username'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($_SESSION['username'])) {
        if ($title != "") {
            if ($description != "") {
                $pdo = new PDO("mysql:host=localhost;dbname=opslag", "bit_academy", "bit_academy");

                $pdo->exec("INSERT INTO tickets (username, title, message) VALUES ('$username', '$title', '$description')");

                header("location: index.php");
                exit;
            } else {
                setcookie("msg_wrong", true, time() + 1);
                header("Location: createticket.php");
            }
        } else {
            setcookie("msg_wrong", true, time() + 1);
            header("Location: createticket.php");
        }
    } else {
        header("location: Front.php");
    }
}
