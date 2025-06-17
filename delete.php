<?php
require_once 'config/db.php';

$id = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->close();

header("Location: index.php");
exit;
?>