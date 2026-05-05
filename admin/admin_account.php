<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
include '../config.php';

// ✅ Run queries before including header
$result_orders = $mysqli->query("SELECT COUNT(*) as total_orders FROM orders");
$total_orders = $result_orders->fetch_assoc()['total_orders'];

$result_sales = $mysqli->query("SELECT SUM(total) as total_sales FROM orders");
$total_sales = $result_sales->fetch_assoc()['total_sales'] ?? 0;

$recent_orders = $mysqli->query("SELECT id, email, total, date 
                                 FROM orders 
                                 ORDER BY date DESC 
                                 LIMIT 5");
?>

<?php include 'header.php'; ?>

<div class="dashboard">

    <!-- Stats -->
    <div class="stats-container">
        <div class="card card-orders">
            <h4><i class="fa fa-shopping-bag"></i> Total Orders</h4>
            <p class="card-value"><?php echo $total_orders; ?></p>
        </div>

        <div class="card card-sales">
            <h4><i class="fa"></i> ৳ Total Sales</h4>
            <p class="card-value">৳<?php echo number_format($total_sales,2); ?></p>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="recent-orders">
        <h4><i class="fa fa-clock"></i> Recent Orders</h4>
        <table class="orders-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User Email</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php
            if($recent_orders && $recent_orders->num_rows > 0){
                while($row = $recent_orders->fetch_assoc()){
                    echo '<tr>
                            <td>#'.$row['id'].'</td>
                            <td>'.htmlspecialchars($row['email']).'</td>
                            <td>৳'.number_format($row['total'],2).'</td>
                            <td>'.date("M d, Y h:i A", strtotime($row['date'])).'</td>
                          </tr>';
                }
            } else {
                echo '<tr><td colspan="4" style="text-align:center;">No recent orders</td></tr>';
            }
            ?>
            </tbody>
        </table>
    </div>

</div>

<style>
.dashboard {
    max-width: 1200px;
    margin: 30px auto;
    padding: 0 20px;
}

/* Stats Cards */
.stats-container {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
    flex-wrap: wrap;
}

.card {
    flex: 1;
    min-width: 250px;
    padding: 20px;
    border-radius: 12px;
    color: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.card h4 {
    margin: 0 0 15px;
    font-size: 1.2em;
    font-weight: 600;
}

.card-value {
    font-size: 2.5em;
    font-weight: bold;
    text-align: center;
}

.card-orders { background: #0078A0; }
.card-sales { background: #28A745; }

/* Recent Orders Table */
.recent-orders h4 {
    margin-bottom: 15px;
    color: #333;
}

.orders-table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.orders-table th, 
.orders-table td {
    padding: 12px 15px;
    text-align: left;
    font-size: 0.95em;
}

.orders-table th {
    background: #0078A0;
    color: #fff;
    font-weight: 600;
}

.orders-table tr:nth-child(even) {
    background: #f9f9f9;
}

.orders-table tr:hover {
    background: #eef7fa;
}
</style>

<?php include 'footer.php'; ?>
