<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}

// Only admin access
if(!isset($_SESSION["username"]) || $_SESSION["type"]!="admin") {
    header("location: ../index.php");
    exit();
}

include '../config.php';

// Fetch all orders with customer info using email
$orders = $mysqli->query("
    SELECT o.*, u.address, u.division, u.district, u.phone 
    FROM orders o 
    LEFT JOIN users u ON o.email = u.email 
    ORDER BY o.date DESC
");

// Count total orders
$total_orders = $orders ? $orders->num_rows : 0;
?>

<?php include 'header.php'; ?> 

<style>
/* Elegant Orders Table */
.orders-container {
    max-width: 1200px;
    margin: 30px auto;
    font-family: Arial, sans-serif;
}

.orders-container h3 {
    color: #0078A0;
    font-size: 24px;
    margin-bottom: 20px;
    border-bottom: 2px solid #0078A0;
    padding-bottom: 8px;
}

.orders-table {
    width: 80%;
    margin: auto;
    border-collapse: collapse;
    background: #fff;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
}

.orders-table th, .orders-table td {
    padding: 10px 10px;
    text-align: center;
}

.orders-table th {
    background: #0078A0;
    color: #fff;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.orders-table tr {
    border-bottom: 1px solid #ddd;
}

.orders-table tr:last-child {
    border-bottom: none;
}

.orders-table tr:hover {
    background: #f1f8ff;
}

.orders-table td .badge {
    padding: 5px 10px;
    border-radius: 12px;
    color: #fff;
    font-size: 0.85em;
}

.badge.pending { background: #f0ad4e; }
.badge.processing { background: #5bc0de; }
.badge.completed { background: #5cb85c; }

.btn {
    display: inline-block;
    padding: 5px 10px;
    margin: 2px;
    border-radius: 4px;
    text-decoration: none;
    color: #fff;
    transition: 0.3s;
}

.btn-edit { background: #0078A0; }
.btn-edit:hover { background: #005f7a; }

.btn-delete { background: #d9534f; }
.btn-delete:hover { background: #c12e2a; }

@media (max-width: 1100px) {
    .orders-table th, .orders-table td {
        padding: 8px 10px;
        font-size: 0.9em;
    }
}
</style>

<div class="orders-container">
    <h3><i class="fa fa-list"></i> All Orders (<?php echo $total_orders; ?>)</h3>
    <table class="orders-table">
        <tr>
            <th>Order ID</th>
            <th>Product</th>
            <th>Customer Address</th>
            <th>Division</th>
            <th>District</th>
            <th>Phone</th>
            <th>Price (৳)</th>
            <th>Units</th>
            <th>Total (৳)</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php
        if($orders && $orders->num_rows > 0){
            while($row = $orders->fetch_assoc()){
                // Status badge
                $statusClass = "pending";
                if(isset($row['status'])){
                    if($row['status'] == "Processing") $statusClass = "processing";
                    if($row['status'] == "Completed") $statusClass = "completed";
                }

                echo '<tr>
                        <td>'.$row['id'].'</td>
                        <td>'.$row['product_name'].'<br><small>'.$row['product_code'].'</small></td>
                        <td>'.($row['address'] ?? '-').'</td>
                        <td>'.($row['division'] ?? '-').'</td>
                        <td>'.($row['district'] ?? '-').'</td>
                        <td>'.($row['phone'] ?? '-').'</td>
                        <td>৳'.number_format($row['price'],2).'</td>
                        <td>'.$row['units'].'</td>
                        <td>৳'.number_format($row['total'],2).'</td>
                        <td>'.$row['date'].'</td>
                        <td><span class="badge '.$statusClass.'">'.($row['status'] ?? "Pending").'</span></td>
                        <td>
                            <a href="order_edit.php?id='.$row['id'].'" class="btn btn-edit"><i class="fa fa-edit"></i></a>
                            <a href="order_delete.php?id='.$row['id'].'" class="btn btn-delete" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>';
            }
        } else {
            echo '<tr><td colspan="12">No orders found.</td></tr>';
        }
        ?>
    </table>
</div>

<?php include 'footer.php'; ?>
