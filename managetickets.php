<?php

include 'database.php';

$pdo->exec("USE opslag");
$stmt = $pdo->query("SELECT * FROM gebruikers");
$gebruikers = $stmt->fetchAll();

foreach ($gebruikers as $gebruiker) {
    if ($_COOKIE["username"] == "Admin" && $_COOKIE["password"] == $gebruiker['password']) {
        $logged_in = true;
    }
}
if (!isset($logged_in)) {
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
                <td>Title:</td>
            </tr>
            <?php
            $pdo->exec("USE opslag");
            $stmt = $pdo->query("SELECT * FROM tickets");
            $tickets = $stmt->fetchAll();

            foreach ($tickets as $ticket) {
                echo "<tr>";
                echo "<td class='c1'>" . $ticket['username'] . "</td>";
                echo "<td class='c2'>" . $ticket['title'] . "</td>";
                echo "<td><button class='Inspect' name='Inspect' value='" . $ticket['id'] . "'>Inspect</button></td>";
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

if (isset($_POST['Inspect'])) {
    $id = $_POST['Inspect'];

    header("Location: ticket.php?id=" . $id);
    exit();
}
