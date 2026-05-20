<?php

session_start();

include 'database.php';

$pdo->exec("USE opslag");
$stmt = $pdo->query("SELECT * FROM gebruikers");
$gebruikers = $stmt->fetchAll();

foreach ($gebruikers as $gebruiker) {
    if ($_SESSION["username"] == "Admin" && $_SESSION["password"] == $gebruiker['password']) {
        $logged_in = true;
    }
}
if (!isset($logged_in)) {
    header("Location: front.php");
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
$stmt->execute([$id]);
$ticket = $stmt->fetch();

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
        <div class="ticket">

            <label>Title:</label>
            <div class="textbg">
            <a class="texts"><?= $ticket['title'] ?></a>
            </div>

            <label>Description:</label>
            <div class="textbg">
            <a class="texts"><?= $ticket['message'] ?></a>
            </div>

            <label>Creation date:</label>
            <div class="textbg">
            <a class="texts"><?= $ticket['created_at'] ?></a>
            </div>

            <button class="delete" name="delete">Delete</button>
        </div>
    </form>
</body>
<footer>
    <p class="TSS">TSS</p>
</footer>

</html>

<?php
if (isset($_POST['back'])) {
    header("location: managetickets.php");
    exit;
}

if (isset($_POST['delete'])) {
    header("location: managetickets.php");
    $stmt = $pdo->prepare("DELETE FROM tickets WHERE id = ?");
    return $stmt->execute([$id]);
}
