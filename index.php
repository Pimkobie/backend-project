<?php

$pdo = new PDO(
    'mysql:host=localhost;port:33060;dbname=opslag',
    'bit_academy',
    'bit_academy'
);

$pdo->exec("USE opslag");
$stmt = $pdo->query("SELECT * FROM tickets");
$tickets = $stmt->fetchAll();
$ticket_number = 0;
$your_ticket_number = 0;

foreach ($tickets as $ticket) {
    $ticket_number++;
    if ($ticket['username'] == $_COOKIE['username']) {
        $your_ticket_number = $your_ticket_number + 1;
    }
}

$pdo->exec("USE opslag");
$stmt = $pdo->query("SELECT * FROM gebruikers");
$gebruikers = $stmt->fetchAll();

foreach ($gebruikers as $gebruiker) {
    if ($_COOKIE["username"] == $gebruiker['username'] && $_COOKIE["password"] == $gebruiker['password']) {
        $logged_in = true;
    }
    if ($gebruiker['username'] == "Admin" && $gebruiker['password'] == $_COOKIE['password']) {
        $admin = true;
    }
}
if (!isset($logged_in)) {
    setcookie("username", "", time() - 1);
    setcookie("password", "", time() - 1);
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
                <td><?= $_COOKIE['username'] ?></td>
                <td><button class="logout" name="logout">Logout</button></td>
            </form>
        </tr>
    </table>

</head>

<body>
    <br>
    <div class="navbar">
        <form method="POST">
            <button class="navbarbuttons" name="manage">Manage Tickets</button>
            <button class="navbarbuttons" name="create">Create Ticket</button>
        </form>
    </div>

    <?php
    if (isset($_COOKIE['wrong_way'])) {
        echo "<a class='wrongmsg'>Manage Tickets is for Admins only!</a>";
    } else {
        echo "<br>";
    }
    ?>

    <div class="stats">
        <h3>Tickets: </h3>
        <?= $ticket_number ?>
        <h3>Your Tickets: </h3>
        <?= $your_ticket_number ?>
    </div>
</body>
<footer>
    <p class="TSS">TSS</p>
</footer>

</html>
<?php
if (isset($_POST['logout'])) {
    setcookie("username", "", time() - 1);
    setcookie("password", "", time() - 1);
    header("Location: front.php");
}

if (isset($_POST['create'])) {
    header("Location: createticket.php");
}

if (isset($_POST['manage'])) {
    if (isset($admin)) {
        header("Location: managetickets.php");
    } else {
        setcookie("wrong_way", true, time() + 1);
        header("Location: index.php");
    }
}
?>