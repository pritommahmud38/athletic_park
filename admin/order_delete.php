<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
include '../config.php';

// Only admin access
if(!isset($_SESSION['username']) || $_SESSION['type'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

// Check if order ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: orders_d.php");
    exit();
}

$order_id = intval($_GET['id']);

// Delete the order from the database
$stmt = $mysqli->prepare("DELETE FROM orders WHERE id=?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->close();

// Redirect back to orders page
header("Location: orders_d.php");
exit();
?>
