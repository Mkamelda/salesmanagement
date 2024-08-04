<?php
include 'config.php';

// Fetch all products
$products = $conn->query("SELECT * FROM products");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #343a40;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #343a40;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: center;
        }
        .table th {
            background-color: #343a40;
            color: #fff;
        }
        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-info {
            background-color: #17a2b8;
            color: #fff;
        }
        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }
        .btn:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Product List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Size</th>
                    <th>Weight</th>
                    <th>Brand</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
// Assuming you have already executed your query and $products is the PDO statement
// Example:
// $stmt = $pdo->prepare("SELECT * FROM products");
// $stmt->execute();
// $products = $stmt;

// Start the while loop to fetch the results
while ($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
    <tr>
        <td><?php echo htmlspecialchars($row['product_id']); ?></td>
        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
        <td><?php echo htmlspecialchars($row['product_type']); ?></td>
        <td><?php echo htmlspecialchars($row['product_quantity']); ?></td>
        <td><?php echo htmlspecialchars($row['product_price']); ?></td>
        <td><?php echo htmlspecialchars($row['product_size']); ?></td>
        <td><?php echo htmlspecialchars($row['product_weight']); ?></td>
        <td><?php echo htmlspecialchars($row['product_brand']); ?></td>
        <td>
            <a href="edit_product.php?id=<?php echo htmlspecialchars($row['product_id']); ?>" class="btn btn-info">Edit</a>
            <form action="manage_products.php" method="post" style="display:inline-block;">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['product_id']); ?>">
                <button type="submit" name="delete_product" class="btn btn-danger">Delete</button>
            </form>
        </td>
    </tr>
<?php endwhile; ?>

            </tbody>
        </table>
    </div>
    <a href="dashboard.php">Back</a>  
</body>
</html>
