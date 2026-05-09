<?php
session_start();
include 'connectiondb.php';

// 1. SECURITY: Check if member is logged in
if (!isset($_SESSION['member_id'])) {
    header("Location: member_login.php");
    exit();
}

$member_id = $_SESSION['member_id'];

// 2. SQL JOIN: Fetch member profile + their specific plan details
$sql = "SELECT m.*, p.plan_name, p.price 
        FROM members m 
        INNER JOIN plans p ON m.plan_id = p.plan_id 
        WHERE m.member_id = '$member_id'";

$result = $conn->query($sql);
$athlete = $result->fetch_assoc();
?>