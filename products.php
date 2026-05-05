<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
include 'config.php';
include 'header.php'; // include the same header as index.php
?>

<!-- Custom CSS for Product Section -->
<style>
/* Products container */
.products-container {
    padding: 20px;
}

/* Products grid */
.row {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 20px;
    margin: 0;
    padding: 0;
}

/* Product box styling */
.product-box {
    width: 250px;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.3s;
    box-sizing: border-box;
    background: #f9f9f9;
}

.product-box:hover {
    transform: scale(1.03);
}

/* Product image */
.product-box img {
    width: 200px;
    height: 150px;
    object-fit: contain;
    margin-bottom: 10px;
}

/* Product text */
.product-box h3 {
    font-size: 18px;
    margin: 10px 0 5px 0;
}

.product-box p {
    font-size: 14px;
    margin: 5px 0;
}

/* Add to Cart button */
.add-to-cart-btn {
    display: inline-block;
    padding: 8px 15px;
    background-color: #0078d7;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 10px;
}

.add-to-cart-btn:hover {
    background-color: #005ea6;
}

/* Out of stock */
.out-of-stock {
    color: red;
    font-weight: bold;
}

/* Responsive adjustments */
@media (max-width: 800px) {
    .product-box { width: 45%; }
}

@media (max-width: 500px) {
    .product-box { width: 90%; }
}
</style>

<!-- Products Section -->
<div class="products-container">
  <div class="row">
    <?php
      $result = $mysqli->query('SELECT * FROM products');
      if($result){
        while($obj = $result->fetch_object()) {
          echo '<div class="product-box">';
          echo '<img src="images/products/'.$obj->product_img_name.'" alt="'.$obj->product_name.'">';
          echo '<h3>'.$obj->product_name.'</h3>';
          echo '<p><strong>Product Code:</strong> '.$obj->product_code.'</p>';
          echo '<p><strong>Description:</strong> '.$obj->product_desc.'</p>';
          echo '<p><strong>Units Available:</strong> '.$obj->qty.'</p>';
         echo '<p><strong>Price:</strong> ৳'.number_format($obj->price, 2).'</p>';
          if($obj->qty > 0){
              echo '<a href="update-cart.php?action=add&id='.$obj->id.'" class="add-to-cart-btn">Add To Cart</a>';
          } else {
              echo '<p class="out-of-stock">Out Of Stock!</p>';
          }
          echo '</div>';
        }
      }
    ?>
  </div>
</div>

<?php include 'footer.php'; // include the same footer as index.php ?>
