<?php
include 'config.php';

$reports = $conn->query("
    SELECT 
        DATE_FORMAT(s.sale_date, '%Y-%m') AS sale_month, 
        p.product_name, 
        SUM(s.quantity_sold) AS total_quantity_sold, 
        SUM(s.quantity_sold * p.product_price) AS total_sales 
    FROM 
        sales s 
    JOIN 
        products p 
    ON 
        s.product_id = p.product_id 
    GROUP BY 
        sale_month, p.product_name
    ORDER BY
        sale_month DESC
");

$monthly_totals = $conn->query("
    SELECT 
        DATE_FORMAT(s.sale_date, '%Y-%m') AS sale_month, 
        SUM(s.quantity_sold * p.product_price) AS total_sales 
    FROM 
        sales s 
    JOIN 
        products p 
    ON 
        s.product_id = p.product_id 
    GROUP BY 
        sale_month
    ORDER BY
        sale_month DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Reports</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f3e8e0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .table th {
            background-color: #8b4513;
            color: white;
        }
        .table tbody tr:nth-child(odd) {
            background-color: #f2e6d9;
        }
        .table tbody tr:nth-child(even) {
            background-color: #e6d4c3;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #8b4513;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .btn-primary {
            background-color: #8b4513;
            border-color: #8b4513;
        }
        .month-header {
            background-color: #a0522d;
            color: white;
            padding: 10px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .monthly-total {
            font-weight: bold;
            margin-top: 10px;
            color: #8b4513;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                Sales Reports
            </div>
            <div class="card-body">
                <?php
                $currentMonth = '';
                $totalSalesPerMonth = [];

                while ($row = $monthly_totals->fetch(PDO::FETCH_ASSOC)) {
                    $totalSalesPerMonth[$row['sale_month']] = $row['total_sales'];
                }

                while ($row = $reports->fetch(PDO::FETCH_ASSOC)) {
                    $month = $row['sale_month'];
                    $formattedMonth = date('F Y', strtotime($month));
                    if ($formattedMonth != $currentMonth) {
                        if ($currentMonth != '') {
                            echo '</tbody></table>';
                            echo '<div class="monthly-total">Total Sales for ' . $currentMonth . ': ' . number_format($totalSalesPerMonth[date('Y-m', strtotime($currentMonth))], 2) . ' TZS</div>';
                        }
                        $currentMonth = $formattedMonth;
                        echo '<div class="month-header">' . $currentMonth . '</div>';
                        echo '<table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Total Quantity Sold</th>
                                        <th>Total Sales</th>
                                    </tr>
                                </thead>
                                <tbody>';
                    }
                    echo '<tr>
                            <td>' . htmlspecialchars($row['product_name']) . '</td>
                            <td>' . htmlspecialchars($row['total_quantity_sold']) . '</td>
                            <td>' . number_format($row['total_sales'], 2) . ' TZS</td>
                          </tr>';
                }
                if ($currentMonth != '') {
                    echo '</tbody></table>';
                    echo '<div class="monthly-total">Total Sales for ' . $currentMonth . ': ' . number_format($totalSalesPerMonth[date('Y-m', strtotime($currentMonth))], 2) . ' TZS</div>';
                }
                ?>
                <a href="dashboard.php" class="btn btn-primary mt-3">Back to Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>
