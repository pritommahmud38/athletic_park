<?php
if(session_id() == '' || !isset($_SESSION)){
    session_start();
}

// Only admin access
if(!isset($_SESSION["username"]) || $_SESSION["type"] !== "admin") {
    echo '<h1>Access Denied! Redirecting...</h1>';
    header("Refresh: 3; url=../index.php"); // redirect to main index
    exit();
}

include '../config.php';  // Correct path to config.php
include 'header.php';     // header.php inside admin folder

// Fetch admin data
$result = $mysqli->query('SELECT * FROM users WHERE id='.$_SESSION['id']);
if($result === FALSE){ die($mysqli->error); }
$obj = $result->fetch_object();

// Handle password update (plain text)
$success_msg = $error_msg = '';
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password'])){
    $new_password = trim($_POST['new_password']);

    if(strlen($new_password) < 4){
        $error_msg = "Password must be at least 4 characters.";
    } else {
        $stmt = $mysqli->prepare("UPDATE users SET password=? WHERE id=? AND type='admin'");
        $stmt->bind_param('si', $new_password, $_SESSION['id']);
        if($stmt->execute()){
            $success_msg = "Password updated successfully!";
        } else {
            $error_msg = "Error updating password. Please try again.";
        }
        $stmt->close();
    }
}
?>

<div class="account-section">
    <h2 class="section-title">Change Admin Password</h2>
    <div class="account-container">
        <div class="account-columns">

            <!-- Left Column: Admin Info -->
            <div class="column user-info">
                <div class="user-image">
                    <img src="../images/users/<?php echo isset($obj->profile_img) ? htmlspecialchars($obj->profile_img) : 'default.png'; ?>" alt="Admin Image">
                </div>
                <h3><?php echo htmlspecialchars($obj->fname.' '.$obj->lname); ?></h3>
                <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($obj->email); ?></p>
            </div>

            <!-- Right Column: Change Password Form -->
            <div class="column change-password">
                <h3>Enter New Password</h3>

                <?php if($success_msg) echo '<p style="color:green; text-align:center;">'.$success_msg.'</p>'; ?>
                <?php if($error_msg) echo '<p style="color:red; text-align:center;">'.$error_msg.'</p>'; ?>

                <form method="POST">
                    <div class="form-group">
                        <input type="password" name="new_password" placeholder="New Password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update Password" class="update-btn">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<style>
.section-title {
    text-align: center;
    font-size: 2em;
    color: #0078d7;
    margin-top: 40px;
    margin-bottom: 20px;
    font-weight: 700;
}
.account-container {
    max-width: 900px;
    margin: 0 auto 50px auto;
    background: #fff;
    padding: 30px;
    border-radius: 30px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.account-columns {
    display: flex;
    gap: 30px;
    flex-wrap: wrap;
}
.column {
    flex: 1;
    min-width: 280px;
}
.user-info {
    text-align: center;
    padding: 20px;
    background: #f0f8ff;
    border-radius: 25px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.user-info .user-image img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.user-info h3 { margin-bottom: 10px; color: #0078d7; }
.user-info p { font-size: 1em; color: #333; }
.change-password {
    padding: 20px;
    background: #f9f9f9;
    border-radius: 25px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.change-password h3 {
    margin-bottom: 15px;
    color: #0078d7;
    text-align: center;
}
.form-group input[type="password"] {
    width: 100%;
    max-width: 350px;
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-size: 1em;
    margin: 0 auto 20px auto;
    display: block;
    transition: border 0.3s, box-shadow 0.3s;
}
.form-group input[type="password"]:focus {
    border-color: #0078d7;
    box-shadow: 0 0 8px rgba(0,120,215,0.2);
    outline: none;
}
.update-btn {
    width: 50%;
    max-width: 200px;
    margin: 0 auto;
    display: block;
    padding: 12px 25px;
    font-size: 1em;
    background-color: #0078d7;
    color: #fff;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: 0.3s;
}
.update-btn:hover {
    background-color: #005ea6;
    transform: scale(1.02);
}
@media (max-width: 700px) {
    .account-columns { flex-direction: column; }
}
</style>

<?php include 'footer.php'; ?>
