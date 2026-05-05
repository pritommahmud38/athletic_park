<?php
if(session_id() == '' || !isset($_SESSION)){ session_start(); }
include 'config.php';
include 'header.php'; // Include your header
?>

<div style="max-width:500px; margin:50px auto; text-align:center; padding:20px; border:1px solid #ddd; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);">

<?php
$fname = $_POST['fname'] ?? '';
$lname = $_POST['lname'] ?? '';
$address = $_POST['address'] ?? '';
$division = $_POST['division'] ?? '';
$district = $_POST['district'] ?? '';
$phone = $_POST['phone'] ?? '';
$email = $_POST['email'] ?? '';
$pwd = $_POST['pwd'] ?? '';

// Check duplicate email
$result = $mysqli->query("SELECT id FROM users WHERE email='$email'");
if($result->num_rows > 0){
    echo "<p style='color:red; font-weight:bold;'>This email is already registered.</p>";
    echo "<p>Redirecting to login page...</p>";
    echo "<script>
            setTimeout(function(){
                window.location.href='login.php';
            }, 3000); // 3 seconds
          </script>";
    include 'footer.php';
    exit();
}

// Handle profile image
$profile_img = 'default.png';
$uploadDir = 'images/users/';
if(!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }

if(isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] == 0){
    $ext = pathinfo($_FILES['profile_img']['name'], PATHINFO_EXTENSION);
    $profile_img = uniqid() . '.' . $ext;
    move_uploaded_file($_FILES['profile_img']['tmp_name'], $uploadDir.$profile_img);
}

// Insert user
$stmt = $mysqli->prepare("INSERT INTO users (fname,lname,address,division,district,phone,email,password,profile_img,type) VALUES (?,?,?,?,?,?,?,?,?,'user')");
$stmt->bind_param('sssssssss', $fname,$lname,$address,$division,$district,$phone,$email,$pwd,$profile_img);

if($stmt->execute()){
    echo "<p style='color:green; font-size:1.2em; font-weight:bold;'>🎉 Profile successfully created!</p>";
    echo "<p>Redirecting to login page...</p>";
} else {
    echo "<p style='color:red; font-weight:bold;'>Error: ".$stmt->error."</p>";
    echo "<p>Redirecting to login page...</p>";
}

// Auto redirect to login.php for both success and duplicate/error
echo "<script>
        setTimeout(function(){
            window.location.href='login.php';
        }, 3000); // 3 seconds
      </script>";

$stmt->close();
$mysqli->close();
?>

</div>

<?php include 'footer.php'; ?>
