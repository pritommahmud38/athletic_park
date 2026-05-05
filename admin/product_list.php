<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}

include '../config.php';

// Only admin access
if(!isset($_SESSION['username']) || $_SESSION['type'] != 'admin'){
    header("Location: ../index.php");
    exit();
}

// Add product logic
if(isset($_POST['add_product'])){
    $product_name   = $_POST['product_name'];
    $product_code   = $_POST['product_code'];
    $product_desc   = $_POST['product_desc'];
    $price          = $_POST['price'];
    $qty            = $_POST['qty'];

    $target_dir     = "../images/products/";
    $product_img_name = basename($_FILES["product_img"]["name"]);
    $target_file    = $target_dir . $product_img_name;

    move_uploaded_file($_FILES["product_img"]["tmp_name"], $target_file);

    $stmt = $mysqli->prepare("INSERT INTO products (product_name, product_code, product_desc, price, qty, product_img_name) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdis", $product_name, $product_code, $product_desc, $price, $qty, $product_img_name);
    $stmt->execute();
    $stmt->close();

    header("Location: product_list.php");
    exit();
}

// Fetch products for stock table
$products = $mysqli->query("SELECT * FROM products ORDER BY id DESC");
$total_products = $products ? $products->num_rows : 0;
?>

<?php include 'header.php'; ?>

<style>
/* Add Product Form */
.admin-form {
    max-width: 1200px;
    margin: 30px auto;
    background: #f9f9f9;
    padding: 25px;
    border-radius: 40px;
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
    margin-bottom: 1px;
    font-weight: bold;
    color: #333;
}
.admin-form input, .admin-form textarea {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    border-radius: 40px;
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

/* Product Stock Table */
.product-stock {
    max-width: 1200px;
    margin: 40px auto;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 3px 8px rgba(0,0,0,0.1);
    overflow-x: auto;
    font-family: Arial, sans-serif;
}
.product-stock h3 {
    margin-bottom: 15px;
    color: #0078A0;
    font-size: 22px;
    border-bottom: 2px solid #0078A0;
    padding-bottom: 8px;
}
.product-stock table {
    width: 100%;
    border-collapse: collapse;
}
.product-stock th, .product-stock td {
    padding: 10px;
    border: 1px solid #ddd;
    text-align: center;
}
.product-stock th {
    background: #0078A0;
    color: #fff;
}
.product-stock img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}
.out-of-stock {
    color: red;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 900px) {
    .admin-form, .product-stock {
        width: 95%;
        margin: 20px auto;
    }
    .form-row {
        flex-direction: column;
    }
}
</style>

<!-- Add Product Form -->
<div class="admin-form">
    <h3><i class="fa fa-plus-circle"></i> Add New Product</h3>
    <form method="post" enctype="multipart/form-data">
        <!-- First Row: Name, Code, Description -->
        <div class="form-row" style="display:flex; gap:10px; flex-wrap:wrap;">
            <div style="flex:1; min-width:150px;">
                <label>Product Name:
                    <input type="text" name="product_name" required>
                </label>
            </div>
            <div style="flex:1; min-width:150px;">
                <label>Product Code:
                    <input type="text" name="product_code" required>
                </label>
            </div>
            <div style="flex:2; min-width:200px;">
                <label>Description:
                    <textarea name="product_desc" required></textarea>
                </label>
            </div>
        </div>

        <!-- Second Row: Price, Quantity, Image -->
        <div class="form-row" style="display:flex; gap:10px; flex-wrap:wrap; margin-top:10px;">
            <div style="flex:1; min-width:150px;">
                <label>Price:
                    <input type="number" step="0.01" name="price" required>
                </label>
            </div>
            <div style="flex:1; min-width:150px;">
                <label>Quantity:
                    <input type="number" name="qty" required>
                </label>
            </div>
            <div style="flex:1; min-width:150px;">
                <label>Product Image:
                    <input type="file" name="product_img" required>
                </label>
            </div>
        </div>

        <!-- Submit Button -->
        <div style="margin-top:15px;">
            <input type="submit" name="add_product" value="Add Product">
        </div>
    </form>
</div>

<!-- Product Stock Table -->
<div class="product-stock">
    <h3><i class="fa fa-box"></i> Current Stock (<?php echo $total_products; ?>)</h3>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Image</th>
            <th>Product Name</th>
            <th>Product Code</th>
            <th>Description</th>
            <th>Price (৳)</th>
            <th>Stock/Units</th>
            <th>Actions</th>
        </tr>
        <?php
        if($products && $products->num_rows > 0){
            while($row = $products->fetch_assoc()){
                $stockClass = ($row['qty'] <= 5) ? 'out-of-stock' : '';
                $imgPath = "../images/products/".($row['product_img_name'] ?? "no-image.png");
                echo '<tr>
                        <td>'.$row['id'].'</td>
                        <td><img src="'.$imgPath.'" alt="'.$row['product_name'].'"></td>
                        <td>'.$row['product_name'].'</td>
                        <td>'.$row['product_code'].'</td>
                        <td>'.$row['product_desc'].'</td>
                        <td>৳'.number_format($row['price'],2).'</td>
                        <td class="'.$stockClass.'">'.($row['qty'] ?? 0).'</td>
                        <td>
                            <a href="product_edit.php?id='.$row['id'].'" class="btn btn-edit"><i class="fa fa-edit"></i></a>
                            <a href="product_delete.php?id='.$row['id'].'" class="btn btn-delete" onclick="return confirm(\'Are you sure?\')"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>';
            }
        } else {
            echo '<tr><td colspan="8">No products found.</td></tr>';
        }
        ?>
    </table>
</div>

<?php include 'footer.php'; ?>
