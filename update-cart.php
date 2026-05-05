<?php
if(session_id() == '' || !isset($_SESSION)){ session_start(); }
include 'config.php';

if(isset($_GET['action'])){
    $id = isset($_GET['id']) ? $_GET['id'] : 0;

    switch($_GET['action']){
        case 'add':
            if(isset($_SESSION['cart'][$id])){
                $_SESSION['cart'][$id]++;
            } else {
                $_SESSION['cart'][$id] = 1;
            }
            break;

        case 'remove':
            if(isset($_SESSION['cart'][$id])){
                $_SESSION['cart'][$id]--;
                if($_SESSION['cart'][$id] <= 0){
                    unset($_SESSION['cart'][$id]);
                }
            }
            break;

        case 'remove_all': // Remove entire product
            if(isset($_SESSION['cart'][$id])){
                unset($_SESSION['cart'][$id]);
            }
            break;

        case 'empty': // Empty whole cart
            unset($_SESSION['cart']);
            break;
    }
}

// Redirect back to cart page
header('Location: cart.php');
exit();
?>
