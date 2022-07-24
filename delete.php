<?php
include("./partials/db.php");

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$id = $_POST['id'];
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($id)) {
        $statement = $pdo->prepare("DELETE FROM users WHERE users.id = $id");

        $statement->execute();
    } else echo $error = true;
    header("location:show.php");
}
