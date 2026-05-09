<?php
include 'connectiondb.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure hashing
    $plan_id = $_POST['plan_id'];

    // 1. Insert into 'members' table first
    $sql_member = "INSERT INTO members (fname, lname, plan_id) VALUES ('$fname', '$lname', '$plan_id')";
    
    if ($conn->query($sql_member) === TRUE) {
        $new_member_id = $conn->insert_id; // Get the ID created for this member

        // 2. Insert into 'member_accounts' table using that ID
        $sql_account = "INSERT INTO member_accounts (member_id, username, password) VALUES ('$new_member_id', '$username', '$password')";
        
        if ($conn->query($sql_account) === TRUE) {
            $message = "success";
        }
    } else {
        $message = "error";
    }
}