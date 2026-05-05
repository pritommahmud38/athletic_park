<?php
if(session_id() == '' || !isset($_SESSION)){ session_start(); }
if(isset($_SESSION["username"])){
    header("Location: index.php");
    exit();
}
include 'header.php';
?>

<div class="account-section">
    <h2 class="section-title">Login to Your Account</h2>
    <div class="login-container">

        <form method="POST" action="verify.php">

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="username" placeholder="user@gmail.com" required>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="pwd" placeholder="Enter your password" required>
            </div>

            <div class="button-wrapper">
                <input type="submit" value="Login" class="btn-primary">
                <input type="reset" value="Reset" class="btn-secondary">
            </div>

            <div class="register-link">
                Don't have an account? <a href="register.php">Register here</a>
            </div>

        </form>

    </div>
</div>

<style>
/* Section Title */
.section-title {
    text-align: center;
    font-size: 2em;
    color: #0078d7;
    margin: 50px 0 30px;
    font-weight: 700;
}

/* Login Container */
.login-container {
    max-width: 400px;
    margin: 0 auto 50px;
    background: #fff;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

/* Form Groups */
.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 20px;
}
.form-group label {
    font-weight: 600;
    margin-bottom: 8px;
}
.form-group input[type="email"],
.form-group input[type="password"] {
    padding: 12px 15px;
    border: 1px solid #ddd;
    border-radius: 25px;
    font-size: 1em;
    transition: border 0.3s, box-shadow 0.3s;
}
.form-group input:focus {
    border-color: #0078d7;
    box-shadow: 0 0 8px rgba(0,120,215,0.2);
    outline: none;
}

/* Buttons */
.button-wrapper {
    text-align: center;
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.btn-primary, .btn-secondary {
    flex: 1;
    padding: 12px;
    font-size: 1em;
    border: none;
    border-radius: 25px;
    cursor: pointer;
    transition: all 0.3s ease;
}
.btn-primary {
    background-color: #0078d7;
    color: #fff;
}
.btn-primary:hover { background-color: #005ea6; transform: scale(1.02); }
.btn-secondary {
    background-color: #ddd;
    color: #333;
}
.btn-secondary:hover { background-color: #bbb; transform: scale(1.02); }

/* Register Link */
.register-link {
    text-align: center;
    margin-top: 20px;
    font-size: 0.95em;
}
.register-link a {
    color: #0078d7;
    font-weight: 600;
    text-decoration: none;
}
.register-link a:hover { text-decoration: underline; }

/* Footer */
footer p {
    text-align: center;
    font-size: 0.8em;
    color: #555;
    margin-top: 50px;
}

/* Responsive */
@media (max-width: 500px) {
    .button-wrapper {
        flex-direction: column;
    }
    .button-wrapper input {
        width: 100%;
    }
}
</style>

<?php include 'footer.php'; ?>
