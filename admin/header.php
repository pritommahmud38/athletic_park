<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
if(!isset($_SESSION['username']) || $_SESSION['type'] != 'admin'){
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Athletic Park Admin</title>
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
nav ul li a { color:#fff; text-decoration:none; display:flex; align-items:center; justify-content:center; height:70px; transition:0.3s; font-size:1.2em; }
nav ul li a:hover { color:#FFD700; }

/* Dropdown */
nav ul li .dropdown {
    display: none;
    position: absolute;
    top: 70px;
    right: 0;
    background: #005f7a;
    border-radius: 8px;
    width: 180px;
    padding: 0;
    z-index: 1000;
}
nav ul li .dropdown li { margin:0; padding:0; list-style:none; }
nav ul li .dropdown li a {
    display:block;
    padding:8px 15px;
    font-size:0.9em;
    color:#fff;
    text-decoration:none;
}
nav ul li .dropdown li a:hover { background:#004a5a; }
nav ul li:hover .dropdown { display:block; }

/* Hamburger */
.hamburger { display:none; flex-direction:column; cursor:pointer; }
.hamburger span { height:3px; width:25px; background:#fff; margin:4px 0; border-radius:2px; transition:0.3s; }

/* Responsive */
@media(max-width:768px){
  nav ul{display:none; flex-direction:column; width:100%; background:#0078A0; gap:15px;}
  nav ul.active{display:flex;}
  nav ul li a{height:50px;}
  .hamburger{display:flex;}
  nav ul li .dropdown { position:static; width:100%; border-radius:0; }
}
</style>
</head>
<body>

<!-- Navigation -->
<nav>
  <div class="nav-container">
    <div class="logo">
      <a href="admin_account.php"><i class="fas fa-cogs"></i> Admin Panel</a>
    </div>

    <div class="hamburger" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <ul id="menu">
      <li><a href="admin_account.php"><i class="fas fa-chart-line"></i></a></li>
      <li><a href="product_list.php"><i class="fas fa-box-open"></i></a></li>
      <li><a href="orders_d.php"><i class="fas fa-shopping-cart"></i></a></li>

      <li>
        <?php
        // Admin profile picture (optional - fallback if none)
        $user_img = '../images/users/default.png';
        if(isset($_SESSION['id'])){
            include '../config.php';
            $result = $mysqli->query("SELECT profile_img FROM users WHERE id=".$_SESSION['id']);
            if($result && $row = $result->fetch_assoc()){
                if(!empty($row['profile_img'])){
                    $user_img = '../images/users/'.$row['profile_img'];
                }
            }
        }
        echo '<a href="#"><img src="'.htmlspecialchars($user_img).'" alt="Admin" style="width:35px;height:35px;border-radius:50%;object-fit:cover;margin-right:5px;"><i class="fas fa-caret-down" style="font-size:1.2em;margin-left:3px;"></i></a>';
        echo '<ul class="dropdown">';
        echo '<li><a href="admin_profile.php"><i class="fas fa-id-badge"></i> Profile</a></li>';
        echo '<li><a href="admin_change_password.php"><i class="fas fa-key"></i> Change Password</a></li>';
        echo '<li><a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>';
        echo '</ul>';
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
