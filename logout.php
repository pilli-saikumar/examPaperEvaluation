<?php
date_default_timezone_set('Asia/Kolkata');
session_start();

// Get user ID before clearing session
$user_id = $_SESSION['FactId'] ?? '';
$role = 'invigilator';

// Log the logout time if user is logged in
if(!empty($user_id)){
    include "config.php"; // Make sure database connection is available
    $logout_time = date('Y-m-d H:i:s');
    $log_query = "UPDATE `user_logs` SET logout = ? WHERE user_id = ? AND role = ? AND logout IS NULL ORDER BY id DESC LIMIT 1";
    
    // Use prepared statement to prevent SQL injection
    if($stmt = $conn->prepare($log_query)) {
        $stmt->bind_param("sss", $logout_time, $user_id, $role);
        $stmt->execute();
        $stmt->close();
    }
}

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: index.php');
exit();
?>