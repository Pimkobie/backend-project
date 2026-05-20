<?php

session_start();    

include 'database.php';

$pdo->exec("USE opslag");
$stmt = $pdo->query("SELECT * FROM tickets");
$tickets = $stmt->fetchAll();
$ticket_number = 0;
$your_ticket_number = 0;

foreach ($tickets as $ticket) {
    $ticket_number++;
    if ($ticket['username'] == $_SESSION['username']) {
        $your_ticket_number = $your_ticket_number + 1;
    }
}

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
        <br><br><br><br>
        <form method="POST">
            <?php
            if (isset($admin)) {
                if ($admin == true) {
                    echo "<button class='userbutton' name='users'>Users</button>";
                }
            }
            ?>
        </form>
    </div>
</body>
<footer>
    <p class="TSS">TSS</p>
</footer>

</html>
<?php
if (isset($_POST['logout'])) {
    unset($_SESSION["username"]);
    unset($_SESSION["password"]);
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

if (isset($_POST['users'])) {
    if (isset($admin)) {
        header("Location: users.php");
    }
}
?>
