<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}

// Redirect if user not logged in
if(!isset($_SESSION["username"])){
  header("location:index.php");
  exit();
}

include 'config.php';
include 'header.php'; // include header like index.php
?>

<!-- Orders Section -->
<div class="products-container" style="margin-top:20px;">
    <h2 style="text-align:center; margin-bottom:20px;">My COD Orders</h2>

    <?php
    $user = $_SESSION["username"];
    $result = $mysqli->query("SELECT * FROM orders WHERE email='".$user."' ORDER BY date DESC");

    if($result && $result->num_rows > 0) {
        echo '<div class="orders-table">';
        echo '<div class="orders-header">';
        echo '<div>Order ID</div><div>Date</div><div>Product Code</div><div>Product Name</div><div>Price</div><div>Units</div><div>Total</div><div>Status</div>';
        echo '</div>';

        while($obj = $result->fetch_object()) {
            echo '<div class="orders-row">';
            echo '<div data-label="Order ID">'.$obj->id.'</div>';
            echo '<div data-label="Date">'.$obj->date.'</div>';
            echo '<div data-label="Product Code">'.$obj->product_code.'</div>';
            echo '<div data-label="Product Name">'.$obj->product_name.'</div>';
            echo '<div data-label="Price">'.$currency.number_format($obj->price,2).'</div>';
            echo '<div data-label="Units">'.$obj->units.'</div>';
            echo '<div data-label="Total">'.$currency.number_format($obj->total,2).'</div>';
            // Add status column
            $status = $obj->status ?? 'Pending'; // default to Pending if status not set
            echo '<div data-label="Status">'.$status.'</div>';
            echo '</div>';
        }

        echo '</div>'; // end orders-table
    } else {
        echo "<p style='text-align:center; font-size:1.1em;'>You have no COD orders.</p>";
    }
    ?>
</div>

<!-- Orders Styles -->
<style>
.products-container {
    max-width: 1000px;
    margin: auto;
}

.orders-table {
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}

.orders-header, .orders-row {
    display: grid;
    grid-template-columns: 1fr 1.5fr 1.5fr 2fr 1fr 1fr 1fr 1fr; /* added Status column */
    padding: 10px 15px;
    align-items: center;
    border-bottom: 1px solid #ddd;
}

.orders-header {
    background-color: #0078d7;
    color: #fff;
    font-weight: bold;
}

.orders-row:nth-child(even) {
    background: #f9f9f9;
}

.orders-row div {
    padding: 5px 0;
    font-size: 14px;
}

@media (max-width: 900px) {
    .orders-header, .orders-row {
        grid-template-columns: repeat(8, 1fr);
        font-size: 12px;
    }
}

@media (max-width: 600px) {
    .orders-header {
        display: none; /* hide header for mobile */
    }

    .orders-row {
        display: grid;
        grid-template-columns: 1fr;
        grid-gap: 5px;
        border-bottom: 2px solid #ddd;
        padding: 10px;
    }

    .orders-row div {
        font-size: 13px;
    }

    .orders-row div::before {
        font-weight: bold;
        content: attr(data-label);
        display: inline-block;
        width: 100px;
    }
}

/* Optional: color code status */
.orders-row div[data-label="Status"] {
    font-weight: bold;
}

.orders-row div[data-label="Status"]:contains("Pending") { color: orange; }
.orders-row div[data-label="Status"]:contains("Ongoing") { color: blue; }
.orders-row div[data-label="Status"]:contains("Delivered") { color: green; }
</style>

<?php include 'footer.php'; ?>
