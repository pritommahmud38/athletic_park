<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
include '../config.php';

// Only admin access
if(!isset($_SESSION['username']) || $_SESSION['type'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

// Check if product ID is provided
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: product_list.php");
    exit();
}

$product_id = intval($_GET['id']);

// Fetch the product to get the image name
$stmt = $mysqli->prepare("SELECT product_img_name FROM products WHERE id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $product = $result->fetch_assoc();
    
    // Delete the product image from server if exists
    if(!empty($product['product_img_name'])){
        $image_path = "../images/products/" . $product['product_img_name'];
        if(file_exists($image_path)){
            unlink($image_path);
        }
    }

    // Delete the product from database
    $stmt_delete = $mysqli->prepare("DELETE FROM products WHERE id=?");
    $stmt_delete->bind_param("i", $product_id);
    $stmt_delete->execute();
    $stmt_delete->close();
}

$stmt->close();

// Redirect back to product list
header("Location: product_list.php");
exit();
?>
