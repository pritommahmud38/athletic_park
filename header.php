<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Athletic Park</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
/* Reset */
body { margin:0; font-family: 'Arial', sans-serif; }

/* Header / Navigation */
nav { background:#0078A0; padding:0 20px; }
nav .nav-container { display:flex; justify-content:space-between; align-items:center; height:70px; max-width:1200px; margin:auto; }
nav .logo a { color:#fff; font-size:1.8em; font-weight:bold; text-decoration:none; }
nav .logo a i { color:#FFD700; margin-right:10px; }
nav ul { display:flex; list-style:none; margin:0; padding:0; align-items:center; gap:25px; }
nav ul li { position:relative; }
nav ul li a { color:#fff; text-decoration:none; display:flex; align-items:center; justify-content:center; height:70px; transition:0.3s; font-size:1.5em; }
nav ul li a:hover { color:#FFD700; }

/* Dropdown as a compact, gapless list */
nav ul li .dropdown {
    display: none;
    position: absolute;
    top: 70px;
    right: 0;
    background: #005f7a;
    border-radius: 8px;
    width: 170px;     
    padding: 0;       
    z-index: 1000;
}
nav ul li .dropdown li {
    margin: 0;
    padding: 0;
    list-style: none;
}
nav ul li .dropdown li a {
    display: block;
    height: auto;
    line-height: 1;
    padding: 5px 15px;
    color: #fff;
    text-decoration: none;
    font-size: 0.9em;
    background: none;
    transition: 0.2s;
}
nav ul li .dropdown li a:hover { 
    background: #004a5a; 
}
nav ul li:hover .dropdown { display: block; }

/* Hamburger */
.hamburger { display:none; flex-direction:column; cursor:pointer; }
.hamburger span { height:3px; width:25px; background:#fff; margin:4px 0; border-radius:2px; transition:0.3s; }

/* Slider */
.slider-container { position: relative; width: 100%; max-height: 500px; overflow: hidden; margin-top: 0; }
.slider-container img { width: 100%; max-height: 500px; object-fit: cover; position: absolute; top: 0; left: 0; opacity: 0; transition: opacity 1s ease-in-out; }
.slider-container img.active { opacity: 1; z-index: 2; position: relative; }

/* Products Grid */
.row { display:flex; flex-wrap:wrap; margin:20px -10px; }
.large-4 { width:calc(33.333% - 20px); margin:10px; }
.product-box { border:1px solid #ddd; padding:15px; text-align:center; background:#f9f9f9; border-radius:8px; }
.product-box img { max-width:100%; height:auto; margin-bottom:10px; }
.add-to-cart-btn { display:inline-block; padding:10px 15px; background:#0078A0; color:#fff; text-decoration:none; border-radius:4px; margin-top:10px; }
.add-to-cart-btn:hover { background:#005f7a; }

/* Footer */
footer { background:#0078A0; color:#fff; text-align:center; padding:20px; margin-top:30px; }

/* Responsive */
@media(max-width:992px){.large-4{width:calc(50% - 20px);} }
@media(max-width:768px){
  .large-4{width:100%;}
  nav ul{display:none; flex-direction:column; width:100%; background:#0078A0; gap:15px;}
  nav ul.active{display:flex;}
  nav ul li a{height:50px;}
  .hamburger{display:flex;}
  nav ul li .dropdown { position:static; width:100%; padding:0; border-radius:0; }
  nav ul li .dropdown li a { padding:5px 15px; font-size:0.9em; line-height:1; }
}
</style>
</head>
<body>

<!-- Navigation -->
<nav>
  <div class="nav-container">
    <div class="logo">
      <a href="index.php"><i class="fas fa-bolt"></i> Athletic Park</a>
    </div>

    <div class="hamburger" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <ul id="menu">
      <li><a href="products.php"><i class="fas fa-box-open"></i></a></li>
      <li><a href="cart.php"><i class="fas fa-shopping-cart"></i></a></li>
      <li><a href="orders.php"><i class="fas fa-clipboard-list"></i></a></li>

      <li>
        <?php
        if(isset($_SESSION['username'])){
            // Fetch user image from database
            $result = $mysqli->query("SELECT profile_img FROM users WHERE id=".$_SESSION['id']);
            $user_img = 'images/users/default.png';
            if($result && $row = $result->fetch_assoc()){
                if(!empty($row['profile_img'])){
                    $user_img = 'images/users/'.$row['profile_img'];
                }
            }
            echo '<a href="#"><img src="'.htmlspecialchars($user_img).'" alt="User" style="width:35px;height:35px;border-radius:50%;object-fit:cover;margin-right:5px;"><i class="fas fa-caret-down" style="font-size:1.2em;margin-left:3px;"></i></a>';
            echo '<ul class="dropdown">';
            echo '<li><a href="account.php"><i class="fas fa-user"></i> My Account</a></li>';
            echo '<li><a href="change_password.php"><i class="fas fa-key"></i> Change Password</a></li>';
            echo '<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>';
            echo '</ul>';
        } else {
            echo '<a href="#"><i class="fas fa-user-circle"></i> <i class="fas fa-caret-down" style="font-size:1.2em;margin-left:3px;"></i></a>';
            echo '<ul class="dropdown">';
            echo '<li><a href="login.php"><i class="fas fa-sign-in-alt"></i> Log In</a></li>';
            echo '<li><a href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>';
            echo '</ul>';
        }
        ?>
      </li>
    </ul>
  </div>
</nav>

<script>
function toggleMenu() {
  document.getElementById('menu').classList.toggle('active');
}
</script>
