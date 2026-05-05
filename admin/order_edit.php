<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}

// Only admin access
if(!isset($_SESSION["username"]) || $_SESSION["type"]!="admin") {
    header("location: ../index.php");
    exit();
}

include '../config.php';

// Check if order ID is passed
if(!isset($_GET['id'])){
    header("location: orders_d.php");
    exit();
}

$order_id = intval($_GET['id']);

// Fetch order details
$order_query = $mysqli->prepare("SELECT * FROM orders WHERE id = ?");
$order_query->bind_param("i", $order_id);
$order_query->execute();
$result = $order_query->get_result();
$order = $result->fetch_assoc();

// If order not found
if(!$order){
    echo "<p style='color:red; font-weight:bold;'>Order not found!</p>";
    exit();
}

// Update order status
if(isset($_POST['update_status'])){
    $status = $_POST['status'];
    $update_query = $mysqli->prepare("UPDATE orders SET status = ? WHERE id = ?");
    $update_query->bind_param("si", $status, $order_id);
    $update_query->execute();
    
    header("location: orders_d.php");
    exit();
}

$status = isset($order['status']) ? $order['status'] : 'Pending';
?>

<?php include 'header.php'; ?>

<div style="max-width: 600px; margin: 50px auto; padding: 30px; background: #f9f9f9; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
    <h2 style="text-align:center; color:#0078A0; margin-bottom: 25px;">Edit Order Status</h2>
    <p style="text-align:center; font-weight:bold;">Order ID: <?php echo $order_id; ?></p>
    
    <form method="POST" style="margin-top: 20px;">
        <label for="status" style="font-weight:bold; display:block; margin-bottom:8px;">Select Status:</label>
        <select name="status" id="status" required style="padding:10px; width:100%; border-radius:5px; border:1px solid #ccc; font-size:16px;">
            <option value="Pending" <?php if($status=="Pending") echo "selected"; ?>>Pending</option>
            <option value="Ongoing" <?php if($status=="Ongoing") echo "selected"; ?>>Ongoing</option>
            <option value="Delivered" <?php if($status=="Delivered") echo "selected"; ?>>Delivered</option>
        </select>

        <div style="margin-top: 20px; display:flex; justify-content:flex-start; gap:10px;">
            <button type="submit" name="update_status" style="flex:1; padding:12px; background:#0078A0; color:#fff; border:none; border-radius:5px; font-size:16px; cursor:pointer;">Update Status</button>
            <a href="orders_d.php" style="flex:1; text-align:center; padding:12px; background:#d9534f; color:#fff; border-radius:5px; text-decoration:none; font-size:16px;">Cancel</a>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
