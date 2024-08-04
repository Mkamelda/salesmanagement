<?php
include 'config.php'; // Ensure your database connection is included correctly

session_start(); // Start the session

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

// Update profile information
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update profile details
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Prepare SQL statement to update user information
    $updateSql = "UPDATE users SET username=:username, email=:email WHERE user_id=:user_id";
    $stmt = $conn->prepare($updateSql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();

    // Handle profile photo upload
    if ($_FILES['profile_photo']['size'] > 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
        if ($check === false) {
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["profile_photo"]["size"] > 500000) { // 500 KB limit
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_extensions = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowed_extensions)) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            // If everything is ok, try to upload file
            if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
                // Update profile photo path in database
                $photo_path = $target_file;
                $stmt = $conn->prepare("UPDATE users SET profile_photo=:profile_photo WHERE user_id=:user_id");
                $stmt->bindParam(':profile_photo', $photo_path);
                $stmt->bindParam(':user_id', $user_id);
                $stmt->execute();

                // Update $user array with new profile photo path
                $user['profile_photo'] = $photo_path;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    // After processing, redirect to avoid form resubmission on refresh
    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #343a40;
        }

        .container {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
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
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #495057;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="file"] {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group input[type="file"]:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn {
            padding: 12px 24px;
            margin: 10px 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary {
            background-color: #007bff;
            color: #ffffff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #ffffff;
        }

        .btn-danger:hover {
            background-color: #bd2130;
        }

        .btn-group {
            text-align: center;
        }

        .profile-img {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            object-fit: cover; /* Ensures the image covers the whole area */
            border: 4px solid #ffffff; /* White border around the image */
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .container {
                width: 80%;
            }
        }

        @media (max-width: 576px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User Profile</h1>
        <div class="btn-group">
            <img src="<?php echo isset($user['profile_photo']) ? $user['profile_photo'] : 'default_profile.png'; ?>" alt="Profile Photo" class="profile-img">
        </div>
        <form action="profile.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label for="profile_photo">Profile Photo:</label>
                <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="dashboard.php" class="btn btn-danger">Back</a>
        </form>
    </div>
</body>
</html>
