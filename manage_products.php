<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_product'])) {
        $name = $_POST['name'];
        $type = $_POST['type'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $size = $_POST['size'];
        $weight = $_POST['weight'];
        $brand = $_POST['brand'];

        $sql = "INSERT INTO products (product_name, product_type, product_quantity, product_price, product_size, product_weight, product_brand) 
                VALUES ('$name', '$type', '$quantity', '$price', '$size', '$weight', '$brand')";
        $conn->query($sql);
    } elseif (isset($_POST['update_product'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $size = $_POST['size'];
        $weight = $_POST['weight'];
        $brand = $_POST['brand'];

        $sql = "UPDATE products 
                SET product_name='$name', product_type='$type', product_quantity='$quantity', product_price='$price', product_size='$size', product_weight='$weight', product_brand='$brand' 
                WHERE product_id='$id'";
        $conn->query($sql);
    } elseif (isset($_POST['delete_product'])) {
        $id = $_POST['id'];

        $sql = "DELETE FROM products WHERE product_id='$id'";
        $conn->query($sql);
    }
}
?>

<<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            margin-top: 20px;
            max-width: 600px; /* Adjusted max-width for better form alignment */
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        form {
            margin-bottom: 40px;
        }
        .form-group {
            margin-bottom: 20px; /* Increased margin between form groups */
        }
        .form-control {
            border-radius: 5px;
            font-size: 16px; /* Increased font size for better readability */
        }
        .btn-primary, .btn-warning {
            width: 48%;
            margin-right: 2%;
        }
        .btn-danger {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Manage Products</h1>
        <form action="manage_products.php" method="post">
            <input type="hidden" name="id" id="product_id">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="type">Product Type:</label>
                <input type="text" class="form-control" name="type" id="type">
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" name="quantity" id="quantity" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" class="form-control" name="price" id="price" required>
            </div>
            <div class="form-group">
                <label for="size">Size:</label>
                <input type="text" class="form-control" name="size" id="size">
            </div>
            <div class="form-group">
                <label for="weight">Weight:</label>
                <input type="text" class="form-control" name="weight" id="weight">
            </div>
            <div class="form-group">
                <label for="brand">Brand:</label>
                <input type="text" class="form-control" name="brand" id="brand">
            </div>
            <button type="submit" name="add_product" class="btn btn-primary">Add Product</button>
            <button type="submit" name="update_product" class="btn btn-warning">Update Product</button>
        </form>
        <a href="product_list.php" class="btn btn-info btn-block">View Product List</a>
        <a href="dashboard.php">Back</a>   
    </div>
    <script>
        function editProduct(id, name, type, quantity, price, size, weight, brand) {
            document.getElementById('product_id').value = id;
            document.getElementById('name').value = name;
            document.getElementById('type').value = type;
            document.getElementById('quantity').value = quantity;
            document.getElementById('price').value = price;
            document.getElementById('size').value = size;
            document.getElementById('weight').value = weight;
            document.getElementById('brand').value = brand;
        }
    </script>
</body>
</html>
