<?php
session_start();
include 'connectiondb.php';
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // JOIN query to get both account and profile info
    $sql = "SELECT ma.*, m.fname FROM member_accounts ma 
            JOIN members m ON ma.member_id = m.member_id 
            WHERE ma.username = '$username'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['member'] = $user['fname'];
            $_SESSION['member_id'] = $user['member_id'];
            header("Location: member_home.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No athlete found with that username.";
    }
}