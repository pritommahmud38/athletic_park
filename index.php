<?php include 'header.php'; ?>

<!-- Custom CSS -->
<style>
/* Remove body padding and margin */
body {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

/* Slider styles */
.slider-container {
    position: relative;
    height: 450px;
    overflow: hidden;
    margin-bottom: 20px;
}

.slider-container img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    z-index: 0;
}

.slider-container img.active {
    opacity: 1;
    z-index: 1;
}

/* Features Box */
.features-box {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 50px;
    background: #f0f8ff;
    padding: 30px 50px;
    margin-bottom: 30px;
    flex-wrap: wrap;
    max-width: 1000px;
    margin-left: auto;
    margin-right: auto;
    border-radius: 50px; /* round edges of the features container */
    box-shadow: 0 5px 15px rgba(0,0,0,0.1); /* subtle shadow */
}

.feature {
    display: flex;
    align-items: center;
    gap: 15px;
    color: #0078d7;
    font-size: 18px;
    padding: 10px 20px; /* add padding for rounded shape */
    background-color: #fff; /* white background for each feature */
    border-radius: 50px; /* make each feature pill-shaped */
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}

.feature:hover {
    transform: scale(1.05); /* subtle hover effect */
}

.feature i {
    font-size: 32px;
}

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
    background: #fff;
}

.product-box:hover {
    transform: scale(1.03);
}

.product-box img {
    width: 200px;
    height: 150px;
    object-fit: contain;
    margin-bottom: 10px;
}

.product-box h3 {
    font-size: 18px;
    margin: 10px 0 5px 0;
}

.product-box p {
    font-size: 14px;
    margin: 5px 0;
}

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

.out-of-stock {
    color: red;
    font-weight: bold;
}

/* Responsive adjustments */
@media (max-width: 800px) {
    .product-box { width: 45%; }
    .features-box { gap: 50px; padding: 25px 30px; }
}

@media (max-width: 500px) {
    .product-box { width: 90%; }
    .features-box { flex-direction: column; gap: 20px; padding: 20px; }
    .feature { justify-content: center; font-size: 16px; padding: 8px 15px; }
    .feature i { font-size: 28px; }
}
</style>

<!-- Slider -->
<div class="slider-container">
  <img src="images/101.jpg" class="active" alt="Slide 1">
  <img src="images/102.jpg" alt="Slide 2">
  <img src="images/103.jpg" alt="Slide 2">
</div>

<!-- Features Box -->
<div class="features-box">
    <div class="feature">
        <i class="fas fa-shield-alt"></i>
        <span>Hassle-Free Warranty</span>
    </div>
    <div class="feature">
        <i class="fas fa-money-bill-wave"></i>
        <span>Cash on Delivery</span>
    </div>
    <div class="feature">
        <i class="fas fa-truck"></i>
        <span>Fast Free Shipping over ৳900</span>
    </div>
</div>

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
          echo '<p><strong>Price:</strong> '.$currency.$obj->price.'</p>';
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

<!-- Slider Script -->
<script>
let slides = document.querySelectorAll('.slider-container img');
let currentIndex = 0;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.style.opacity = 0;
        slide.style.zIndex = 0;
    });
    slides[index].style.opacity = 1;
    slides[index].style.zIndex = 1;
}

function nextSlide() {
    currentIndex++;
    if(currentIndex >= slides.length) currentIndex = 0;
    showSlide(currentIndex);
}

// Initial display
showSlide(currentIndex);
setInterval(nextSlide, 3000);
</script>

<?php include 'footer.php'; ?>
