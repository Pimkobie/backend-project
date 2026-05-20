<?php

session_start();

include 'database.php';

$pdo->exec("USE opslag");
$stmt = $pdo->query("SELECT * FROM gebruikers");
$gebruikers = $stmt->fetchAll();

foreach ($gebruikers as $gebruiker) {
    if ($_SESSION["username"] == $gebruiker['username'] && $_SESSION["password"] == $gebruiker['password']) {
        $logged_in = true;
        if ($gebruiker['is_admin'] == true) {
            $admin = true;
        }
    }
}
if (!isset($admin)) {
    header("Location: index.php");
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
        <table class="tickets">
            <tr>
                <td>Name:</td>
                <td>Admin:</td>
            </tr>
            <?php
            $pdo->exec("USE opslag");
            $stmt = $pdo->query("SELECT * FROM gebruikers");
            $tickets = $stmt->fetchAll();

            foreach ($gebruikers as $gebruiker) {
                if ($gebruiker['is_admin'] == true) {
                    $is_admin = "true";
                } else {
                    $is_admin = "false";
                }

                echo "<tr>";
                echo "<td class='c1'>" . $gebruiker['username'] . "</td>";
                echo "<td class='c2'>" . $is_admin . "</td>";
                echo "<td><button class='Inspect' name='admin' value='" . $gebruiker['username'] . "'>Change</button></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </form>
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

if (isset($_POST['admin'])) {
    $u = $_POST['admin'];

    $stmt = $pdo->prepare("SELECT * FROM gebruikers WHERE username = ?");
    $stmt->execute([$u]);
    $user = $stmt->fetch();



    if ($user['is_admin'] == true) {
        $stmt = $pdo->prepare("UPDATE gebruikers SET is_admin = false WHERE username = ?");
        $stmt->execute([$u]);
    } else if ($user['is_admin'] == false) {
        $stmt = $pdo->prepare("UPDATE gebruikers SET is_admin = true WHERE username = ?");
        $stmt->execute([$u]);
    }

    header("location: users.php");
    exit();
}
