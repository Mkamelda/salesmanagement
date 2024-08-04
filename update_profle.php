<?php
// Assuming you have a database connection established in config.php or similar
require 'config.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];

    // Handle profile photo upload if a file was selected
    if ($_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['profile_photo']['tmp_name'];
        $file_name = $_FILES['profile_photo']['name'];
        $file_type = $_FILES['profile_photo']['type'];
        $file_size = $_FILES['profile_photo']['size'];

        // Move uploaded file to desired location (e.g., uploads folder)
        $upload_dir = 'uploads/';
        $uploaded_file = $upload_dir . basename($file_name);
        
        if (move_uploaded_file($file_tmp, $uploaded_file)) {
            // Update database with new profile photo path (assuming user_id is available in session or POST)
            $user_id = 1; // Example user ID; replace with your actual logic to get user ID
            $profile_photo_path = $uploaded_file;

            // Update query
            $stmt = $conn->prepare('UPDATE users SET username = :username, email = :email, profile_photo = :profile_photo WHERE id = :user_id');
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':profile_photo', $profile_photo_path);
            $stmt->bindParam(':user_id', $user_id);

            if ($stmt->execute()) {
                // Redirect to profile page or dashboard after update
                header("Location: profile.php");
                exit();
            } else {
                echo "Error updating profile: " . $stmt->errorInfo()[2];
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Error: No file uploaded.";
    }
}
?>
