<?php
if(session_id() == '' || !isset($_SESSION)){ session_start(); }
if (isset($_SESSION["username"])) { header("location:index.php"); exit(); }
include 'header.php';
?>

<div class="account-section">
    <h2 class="section-title">Create Your Account</h2>
    <div class="account-container">

        <div class="account-columns">

            <!-- Left Column: Profile Preview -->
            <div class="column profile-preview">
                <h3>Profile Preview</h3>
                <img id="preview" src="images/users/default.png" alt="Profile Preview">
                <div class="preview-info">
                    <p><strong>Name:</strong> <span id="preview_name">Your Name</span></p>
                    <p><strong>Phone:</strong> <span id="preview_phone">+880XXXXXXXXXX</span></p>
                    <p><strong>Email:</strong> <span id="preview_email">email@example.com</span></p>
                    <p><strong>Address:</strong> <span id="preview_address">Address</span></p>
                    <p><strong>Division:</strong> <span id="preview_division">Division</span></p>
                    <p><strong>District:</strong> <span id="preview_district">District</span></p>
                </div>
            </div>

            <!-- Right Column: Registration Form -->
            <div class="column registration-form">
                <form method="POST" action="insert.php" enctype="multipart/form-data">

                    <!-- Name -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="fname" placeholder="First Name" oninput="updatePreview()" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="lname" placeholder="Last Name" oninput="updatePreview()" required>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address" placeholder="Address" oninput="updatePreview()" required>
                    </div>

                    <!-- Division & District -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Division</label>
                            <select name="division" id="division" required onchange="updateDistricts(); updatePreview()">
                                <option value="">Select Division</option>
                                <option value="Dhaka">Dhaka</option>
                                <option value="Chattogram">Chattogram</option>
                                <option value="Khulna">Khulna</option>
                                <option value="Rajshahi">Rajshahi</option>
                                <option value="Barishal">Barishal</option>
                                <option value="Sylhet">Sylhet</option>
                                <option value="Rangpur">Rangpur</option>
                                <option value="Mymensingh">Mymensingh</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>District</label>
                            <select name="district" id="district" required onchange="updatePreview()">
                                <option value="">Select District</option>
                            </select>
                        </div>
                    </div>

                    <!-- Phone & Email -->
                    <div class="form-row">
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" name="phone" placeholder="+880XXXXXXXXXX" oninput="updatePreview()" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" placeholder="email@example.com" oninput="updatePreview()" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="pwd" placeholder="Password" required>
                    </div>

                    <!-- Profile Image -->
                    <div class="form-group">
                        <label for="profile_img">Upload Profile Image</label>
                        <input type="file" name="profile_img" id="profile_img" accept="image/*" onchange="previewImage(event)">
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group">
                        <input type="submit" value="Register" class="update-btn">
                    </div>

                    <!-- Login Link -->
                    <div class="login-link">
                        Already have an account? <a href="login.php">Log in here</a>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

<style>
/* Section Title */
.section-title {
    text-align: center;
    font-size: 2.2em;
    color: #0078d7;
    margin: 50px 0 30px;
    font-weight: 700;
}

/* Container */
.account-container {
    max-width: 1000px;
    margin: 0 auto 50px;
    background: #fff;
    padding: 40px;
    border-radius: 25px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Columns Layout */
.account-columns {
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}
.column { flex: 1; min-width: 320px; }

/* Profile Preview */
.profile-preview {
    text-align: center;
    padding: 25px;
    background: #f0f8ff;
    border-radius: 25px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.profile-preview img {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 2px solid #ddd;
}
.preview-info p {
    font-size: 1em;
    margin: 10px 0; /* uniform spacing */
}

/* Form */
.registration-form { padding: 0 10px; }
.form-row { display: flex; gap: 25px; flex-wrap: wrap; margin-bottom: 2px; }
.form-group { flex: 1; display: flex; flex-direction: column; margin-bottom: 2px; }
.form-group label { margin-bottom: 2px; font-weight: 600; }
input[type="text"], input[type="email"], input[type="password"], select, input[type="file"] {
    width: 100%;
    padding: 10px 8px;
    border: 2px solid #ddd;
    border-radius: 25px;
    font-size: 1em;
    margin: 0;
    transition: border 0.3s, box-shadow 0.3s;
}
input:focus, select:focus { border-color: #0078d7; box-shadow: 0 0 8px rgba(0,120,215,0.2); outline: none; }

/* Submit Button */
.update-btn {
    width: 50%;
    max-width: 220px;
    margin: 20px auto 0;
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
.update-btn:hover { background-color: #005ea6; transform: scale(1.02); }

/* Login Link */
.login-link { text-align: center; margin-top: 15px; font-size: 0.95em; }
.login-link a { color: #0078d7; font-weight: 600; text-decoration: none; }
.login-link a:hover { text-decoration: underline; }

/* Responsive */
@media (max-width: 900px) {
    .account-columns { flex-direction: column; }
    .form-row { flex-direction: column; gap: 15px; }
    .update-btn { width: 100%; }
}
</style>

<script>
const districtsByDivision = {
    "Dhaka": ["Dhaka","Faridpur","Gazipur","Gopalganj","Kishoreganj","Madaripur","Manikganj","Munshiganj","Narayanganj","Narsingdi","Rajbari","Shariatpur","Tangail"],
    "Chattogram": ["Bandarban","Brahmanbaria","Chandpur","Chattogram","Comilla","Cox's Bazar","Feni","Khagrachari","Lakshmipur","Noakhali","Rangamati"],
    "Khulna": ["Bagerhat","Chuadanga","Jessore","Jhenaidah","Khulna","Kushtia","Magura","Meherpur","Narail","Satkhira"],
    "Rajshahi": ["Bogra","Chapainawabganj","Dinajpur","Joypurhat","Naogaon","Natore","Pabna","Rajshahi"],
    "Barishal": ["Barguna","Barishal","Bhola","Jhalokathi","Patuakhali","Pirojpur"],
    "Sylhet": ["Habiganj","Moulvibazar","Sunamganj","Sylhet"],
    "Rangpur": ["Dinajpur","Gaibandha","Kurigram","Lalmonirhat","Nilphamari","Panchagarh","Rangpur","Thakurgaon"],
    "Mymensingh": ["Jamalpur","Mymensingh","Netrokona","Sherpur"]
};

function updateDistricts() {
    const division = document.getElementById("division").value;
    const districtSelect = document.getElementById("district");
    districtSelect.innerHTML = '<option value="">Select District</option>';
    if(districtsByDivision[division]) {
        districtsByDivision[division].forEach(d => {
            const option = document.createElement("option");
            option.value = d; option.text = d;
            districtSelect.appendChild(option);
        });
    }
}

function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){ document.getElementById('preview').src = reader.result; };
    reader.readAsDataURL(event.target.files[0]);
}

function updatePreview() {
    const fname = document.querySelector('input[name="fname"]').value;
    const lname = document.querySelector('input[name="lname"]').value;
    document.getElementById('preview_name').innerText = (fname + ' ' + lname) || 'Your Name';
    document.getElementById('preview_phone').innerText = document.querySelector('input[name="phone"]').value || '+880XXXXXXXXXX';
    document.getElementById('preview_email').innerText = document.querySelector('input[name="email"]').value || 'email@example.com';
    document.getElementById('preview_address').innerText = document.querySelector('input[name="address"]').value || 'Address';
    document.getElementById('preview_division').innerText = document.getElementById('division').value || 'Division';
    document.getElementById('preview_district').innerText = document.getElementById('district').value || 'District';
}
</script>

<?php include 'footer.php'; ?>
