<?php

require "../components/auth.php";
require "../components/pdo.php";

require_admin();

$id = $_GET["id"];

$stmt = $pdo->prepare(
    "DELETE FROM users WHERE id=?"
);

$stmt->execute([$id]);

header("Location: admin_users.php");
exit();

?>