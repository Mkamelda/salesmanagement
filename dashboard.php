

<?php
include 'config.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$stmt = $conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            margin: 0;
            background: linear-gradient(to bottom right, #f3e5ab, #dbc69f);
            color: #333;
        }
        .sidebar {
            width: 250px;
            background-color: #e2d2b3;
            position: fixed;
            height: 100%;
            padding-top: 20px;
            transition: width 0.3s;
        }
        .sidebar a {
            padding: 15px 20px;
            text-decoration: none;
            font-size: 18px;
            color: #333;
            display: block;
            transition: background-color 0.3s, color 0.3s;
        }
        .sidebar a:hover {
            background-color: #d1c2a3;
            color: #333;
        }
        .sidebar .active {
            background-color: #c3b496;
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
            transition: margin-left 0.3s, width 0.3s;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            .sidebar a {
                text-align: center;
                float: none;
            }
            .content {
                margin-left: 0;
                width: 100%;
            }
        }
        .navbar {
            background-color: #c3b496;
            color: #333;
        }
        .navbar .navbar-brand {
            color: #333;
        }
        .navbar .nav-link {
            color: #333;
        }
        .navbar .nav-link:hover {
            color: #666;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            background-color: #fff;
        }
        .card .card-header {
            font-weight: bold;
            text-align: center;
            background-color: #e2d2b3;
            color: #333;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .card .btn {
            display: block;
            margin: 0 auto;
            width: 80%;
            background-color: #c3b496;
            color: #fff;
            border: none;
        }
        .card .btn:hover {
            background-color: #a89b7f;
        }
        .welcome-message {
            text-align: center;
            margin-bottom: 40px;
            font-size: 24px;
            font-weight: bold;
        }
        .professional-bg {
            background: url('business_background.jpg') no-repeat center center fixed;
            background-size: cover;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.2;
        }
    </style>
</head>
<body>
    <div class="professional-bg"></div>
    <div class="sidebar">
        <a class="active" href="#">Menu</a>
        <a href="index.html">Home</a>
        <a href="profile.php">Profile</a>
        <a href="manage_products.php">Manage Products</a>
        <a href="manage_sales.php">Sales</a>
        <a href="view_reports.php">Reports</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="content">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container mt-5">
            <div class="welcome-message">
                Welcome, <?php echo isset($user['username']) ? htmlspecialchars($user['username']) : 'User'; ?>!
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Manage Products</div>
                        <div class="card-body">
                            <h5 class="card-title">Add, Update, Delete Products</h5>
                            <p class="card-text">Keep your inventory up to date.</p>
                            <a href="manage_products.php" class="btn">Go to Products</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Sales</div>
                        <div class="card-body">
                            <h5 class="card-title">View and Manage Sales</h5>
                            <p class="card-text">Track your sales performance.</p>
                            <a href="manage_sales.php" class="btn">Go to Sales</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">Reports</div>
                        <div class="card-body">
                            <h5 class="card-title">View Reports</h5>
                            <p class="card-text">Generate and view sales reports.</p>
                            <a href="view_reports.php" class="btn">Go to Reports</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
