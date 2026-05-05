<?php
if(session_id() == '' || !isset($_SESSION)){ session_start(); }

// Only admin access
if(!isset($_SESSION["username"]) || $_SESSION["type"] !== "admin") {
    echo '<h1>Access Denied! Redirecting...</h1>';
    header("Refresh: 3; url=../index.php"); // redirect to main index
    exit();
}

include '../config.php';  // Path to config.php from admin folder
include 'header.php';     // admin/header.php

// Fetch admin data
$result = $mysqli->query("SELECT * FROM users WHERE id=".$_SESSION['id']." AND type='admin'");
if(!$result){ die($mysqli->error); }
$user = $result->fetch_object();
?>

<div class="account-section">
    <h2 class="section-title">Admin Account</h2>
    <div class="account-container">

        <div class="user-profile">
            <div class="profile-img">
                <img src="../images/users/<?php echo isset($user->profile_img) ? htmlspecialchars($user->profile_img) : 'default.png'; ?>" alt="Admin Image">
            </div>
            <div class="profile-details">
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user->fname.' '.$user->lname); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($user->phone); ?></p>
                <p><strong>Address:</strong> <?php echo htmlspecialchars($user->address); ?></p>
                <p><strong>Division:</strong> <?php echo htmlspecialchars($user->division); ?></p>
                <p><strong>District:</strong> <?php echo htmlspecialchars($user->district); ?></p>
            </div>
        </div>

    </div>
</div>

<style>
.section-title {
    text-align: center;
    font-size: 2em;
    color: #0078d7;
    margin: 40px 0 30px;
    font-weight: 700;
}

.account-container {
    max-width: 800px;
    margin: 0 auto 50px;
    background: #fff;
    padding: 30px 25px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.user-profile {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 30px;
}

.profile-img img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ddd;
}

.profile-details {
    flex: 1;
    min-width: 250px;
}

.profile-details p {
    font-size: 1em;
    margin: 10px 0;
    color: #333;
}

@media(max-width: 700px) {
    .user-profile { flex-direction: column; align-items: center; }
    .profile-details { text-align: center; }
}
</style>

<?php include 'footer.php'; ?>
