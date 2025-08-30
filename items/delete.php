<?php
require_once "../session.php";
require_once "../config/db.php";

$id = $_GET['id'];
$conn->query("DELETE FROM items WHERE id=$id");
header("Location: list.php");
exit();
