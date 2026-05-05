<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
include 'config.php';
?>

<?php include 'header.php'; ?>

<!-- Cart Section -->
<div class="products-container" style="margin-top:20px;">
    <h2 style="text-align:center; margin-bottom:20px;">Your Shopping Cart</h2>

    <?php
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

        $total = 0;
        echo '<div class="cart-table">';
        echo '<div class="cart-header">';
        echo '<div>Image</div><div>Code</div><div>Name</div><div>Quantity</div><div>Cost</div><div>Action</div>';
        echo '</div>';

        foreach($_SESSION['cart'] as $product_id => $quantity) {

            $result = $mysqli->query("SELECT product_code, product_name, product_desc, qty, price, product_img_name FROM products WHERE id = ".$product_id);

            if($result){
                while($obj = $result->fetch_object()) {
                    $cost = $obj->price * $quantity;
                    $total += $cost;

                    echo '<div class="cart-row">';
                    echo '<div><img src="images/products/'.$obj->product_img_name.'" alt="'.$obj->product_name.'" class="cart-image"></div>';
                    echo '<div>'.$obj->product_code.'</div>';
                    echo '<div>'.$obj->product_name.'</div>';
                    echo '<div>
                            '.$quantity.' 
                            <a class="cart-btn add" href="update-cart.php?action=add&id='.$product_id.'">+</a>
                            <a class="cart-btn remove" href="update-cart.php?action=remove&id='.$product_id.'">-</a>
                          </div>';
                    echo '<div>৳'.number_format($cost,2).'</div>';
                    // Remove button with trash icon
                    echo '<div><a href="update-cart.php?action=remove_all&id='.$product_id.'" class="cart-btn remove-all" title="Remove"><i class="fas fa-trash"></i></a></div>';
                    echo '</div>';
                }
            }
        }

        echo '<div class="cart-row total">';
        echo '<div colspan="5" style="text-align:right;"><strong>Total:</strong></div>';
        echo '<div>৳'.number_format($total,2).'</div>';
        echo '</div>';

        echo '<div class="cart-actions">';
        echo '<a href="update-cart.php?action=empty" class="cart-action-btn">Empty Cart</a>';
        echo '<a href="products.php" class="cart-action-btn">Continue Shopping</a>';

        if(isset($_SESSION['username'])) {
            echo '<a href="orders-update.php" class="cart-action-btn">Place Order (COD)</a>';
        } else {
            echo '<a href="login.php" class="cart-action-btn">Login to Order</a>';
        }
        echo '</div>';

        echo '</div>'; // end cart-table

    } else {
        echo "<p style='text-align:center; font-size:1.1em;'>You have no items in your shopping cart.</p>";
    }
    ?>
</div>

<!-- Cart Styles -->
<style>
/* Font Awesome for trash icon */
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');

.products-container {
    max-width: 1000px;
    margin: auto;
}

.cart-table {
    border: 1px solid #ddd;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
}

.cart-header, .cart-row {
    display: grid;
    grid-template-columns: 100px 1fr 2fr 2fr 1fr 1fr; /* Added column for Remove */
    padding: 10px 15px;
    border-bottom: 1px solid #ddd;
    align-items: center;
    gap: 10px;
}

.cart-header {
    background-color: #0078d7;
    color: #fff;
    font-weight: bold;
}

.cart-row:nth-child(even) {
    background: #f9f9f9;
}

.cart-row.total {
    font-size: 1.2em;
    font-weight: bold;
    border-top: 2px solid #0078d7;
}

.cart-image {
    width: 70px;
    height: auto;
    border-radius: 5px;
}

.cart-btn {
    display: inline-block;
    padding: 3px 8px;
    margin-left: 5px;
    border-radius: 5px;
    text-decoration: none;
    color: #fff;
    font-weight: bold;
}

.cart-btn.add {
    background-color: #28a745;
}

.cart-btn.remove {
    background-color: #dc3545;
}

.cart-btn.remove-all {
    background-color: #ff5722;
}

.cart-btn.add:hover { background-color: #218838; }
.cart-btn.remove:hover { background-color: #c82333; }
.cart-btn.remove-all:hover { background-color: #e64a19; }

/* Trash icon size */
.cart-btn.remove-all i {
    font-size: 16px;
}

.cart-actions {
    margin-top: 15px;
    display: flex;
    justify-content: flex-end;
    flex-wrap: wrap;
    gap: 10px;
}

.cart-action-btn {
    padding: 8px 15px;
    border-radius: 5px;
    background-color: #0078d7;
    color: #fff;
    text-decoration: none;
    font-weight: bold;
}

.cart-action-btn:hover {
    background-color: #005ea6;
}
</style>

<?php include 'footer.php'; ?>
