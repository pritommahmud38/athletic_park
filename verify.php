<?php
if(session_id() == '' || !isset($_SESSION)){ session_start(); }
include 'config.php';

if(!isset($_POST["username"]) || !isset($_POST["pwd"])){
    header("Location: login.php");
    exit();
}

$username = trim($_POST["username"]);
$password = trim($_POST["pwd"]);

// Prepare statement
$stmt = $mysqli->prepare("SELECT id, fname, lname, address, phone, district, division, email, password, type 
                          FROM users 
                          WHERE email = ? 
                          LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows === 1){
    $user = $result->fetch_assoc();
    $dbPass = $user['password'];

    // Check if password is hashed
    if(substr($dbPass, 0, 4) === '$2y$'){
        $loginSuccess = password_verify($password, $dbPass);
    } else { 
        // plaintext fallback
        $loginSuccess = ($dbPass === $password);
    }

    if($loginSuccess){
        // Set session values
        $_SESSION['username'] = $user['email'];
        $_SESSION['type'] = $user['type'];
        $_SESSION['id'] = $user['id'];
        $_SESSION['fname'] = $user['fname'];

        // Redirect based on user type
        if($user['type'] === "admin"){
            header("Location: admin/admin_account.php");
        } else {
            header("Location: index.php");
        }
        exit();
    } else {
        $error = "Incorrect password!";
    }

} else {
    $error = "User not found!";
}

// Login failed
echo "<h1>$error Redirecting to login page...</h1>";
header("Refresh: 3; url=login.php");
exit();
?>
