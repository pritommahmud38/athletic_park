<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
include '../config.php';

// Only admin access
if(!isset($_SESSION['username']) || $_SESSION['type'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

// Get product ID from URL
if(!isset($_GET['id']) || empty($_GET['id'])){
    header("Location: product_list.php");
    exit();
}

$product_id = intval($_GET['id']);

// Fetch product details
$stmt = $mysqli->prepare("SELECT * FROM products WHERE id=?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows == 0){
    echo "Product not found!";
    exit();
}

$product = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if(isset($_POST['update_product'])){
    $product_name   = $_POST['product_name'];
    $product_code   = $_POST['product_code'];
    $product_desc   = $_POST['product_desc'];
    $price          = $_POST['price'];
    $qty            = $_POST['qty'];

    // Check if new image uploaded
    if(isset($_FILES['product_img']) && $_FILES['product_img']['name'] != ''){
        $target_dir = "../images/products/";
        $product_img_name = basename($_FILES["product_img"]["name"]);
        $target_file = $target_dir . $product_img_name;
        move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file);
    } else {
        $product_img_name = $product['product_img_name']; // keep existing image
    }

    $stmt = $mysqli->prepare("UPDATE products SET product_name=?, product_code=?, product_desc=?, price=?, qty=?, product_img_name=? WHERE id=?");
    $stmt->bind_param("sssdisi", $product_name, $product_code, $product_desc, $price, $qty, $product_img_name, $product_id);
    $stmt->execute();
    $stmt->close();

    header("Location: product_list.php");
    exit();
}

?>

<?php include 'header.php'; ?>

<style>
.admin-form {
    max-width: 600px;
    margin: 30px auto;
    background: #f9f9f9;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    font-family: Arial, sans-serif;
}
.admin-form h3 {
    margin-bottom: 20px;
    color: #0078A0;
    font-size: 22px;
    border-bottom: 2px solid #0078A0;
    padding-bottom: 8px;
}
.admin-form label {
    display: block;
    margin-bottom: 12px;
    font-weight: bold;
    color: #333;
}
.admin-form input, .admin-form textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 6px;
    border: 1px solid #ccc;
    box-sizing: border-box;
}
.admin-form input[type="submit"] {
    background:#0078A0;
    color:#fff;
    border:none;
    cursor:pointer;
    transition:0.3s;
    margin-top: 15px;
}
.admin-form input[type="submit"]:hover {
    background:#005f7a;
}
.product-img-preview {
    width: 120px;
    height: 80px;
    object-fit: cover;
    margin-top: 10px;
    border-radius: 4px;
}
</style>

<div class="admin-form">
    <h3><i class="fa fa-edit"></i> Edit Product</h3>
    <form method="post" enctype="multipart/form-data">
        <label>Product Name:
            <input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
        </label>
        <label>Product Code:
            <input type="text" name="product_code" value="<?php echo htmlspecialchars($product['product_code']); ?>" required>
        </label>
        <label>Description:
            <textarea name="product_desc" required><?php echo htmlspecialchars($product['product_desc']); ?></textarea>
        </label>
        <label>Price:
            <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
        </label>
        <label>Quantity:
            <input type="number" name="qty" value="<?php echo $product['qty']; ?>" required>
        </label>
        <label>Product Image:
            <input type="file" name="product_img">
            <?php if($product['product_img_name']): ?>
                <img src="../images/products/<?php echo $product['product_img_name']; ?>" class="product-img-preview" alt="Current Image">
            <?php endif; ?>
        </label>
        <input type="submit" name="update_product" value="Update Product">
    </form>
</div>

<?php include 'footer.php'; ?>
