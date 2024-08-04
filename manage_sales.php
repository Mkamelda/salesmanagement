<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];
    $quantity_sold = $_POST['quantity'];

    // Use prepared statements to prevent SQL injection
    $sql = "INSERT INTO sales (product_id, quantity_sold) VALUES (:product_id, :quantity_sold)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['product_id' => $product_id, 'quantity_sold' => $quantity_sold]);

    $sql = "UPDATE products SET product_quantity = product_quantity - :quantity_sold WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['quantity_sold' => $quantity_sold, 'product_id' => $product_id]);
}

// Fetch products
$products = $conn->query("SELECT * FROM products");

// Fetch sales with product names
$sales = $conn->query("SELECT sales.*, products.product_name FROM sales JOIN products ON sales.product_id = products.product_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sales</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f3e8e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .btn {
            width: 100%;
        }
        table {
            margin-top: 20px;
        }
        table th, table td {
            text-align: center;
        }
        table th {
            background-color: #8b4513;
            color: white;
        }
        table tbody tr:nth-child(odd) {
            background-color: #f2e6d9;
        }
        table tbody tr:nth-child(even) {
            background-color: #e6d4c3;
        }
        .btn-primary {
            background-color: #8b4513;
            border-color: #8b4513;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Manage Sales</h1>
        <form action="manage_sales.php" method="post" class="mb-4">
            <div class="form-group">
                <label for="product_id">Product:</label>
                <select class="form-control" name="product_id" id="product_id" required>
                    <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?php echo htmlspecialchars($row['product_id']); ?>"><?php echo htmlspecialchars($row['product_name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity Sold:</label>
                <input type="number" class="form-control" name="quantity" id="quantity" required>
            </div>
            <button type="submit" class="btn btn-primary">Record Sale</button>
        </form>
        <h2 class="text-center">Sales Records</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Quantity Sold</th>
                    <th>Sale Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $sales->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['sale_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['quantity_sold']); ?></td>
                        <td><?php echo htmlspecialchars($row['sale_date']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <a href="dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
</body>
</html>
                                                                                                                                                                                                                                               