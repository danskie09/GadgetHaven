<?php

include('dbcon.php');
session_start();

// Check if customer is logged in, if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to your login page
    exit();
}



$user_id = $_SESSION['user_id'];

// Fetch customer's data from the database
$sql = "SELECT firstname, lastname,email FROM user WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_firstname = $row['firstname'];
    $user_lastname = $row['lastname'];
    $user_email = $row['email'];
} else {
    // Handle the case where customer data is not found
    $user_firstname = 'Unknown';
    $user_lastname = 'Unknown';
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Information Page</title>
  
</head>
<body>

  <header>
    <h1>User Information</h1>
  </header>

  <section>
    <h2>Personal Details</h2>
    <ul>
      <li>
        <label for="username">Username:</label>
        <span id="username"><?php echo $user_firstname; ?></span>
      </li>
      <li>
        <label for="fullName">Full Name:</label>
        <span id="fullName"><?php echo $user_lastname; ?></span>
      </li>
      <li>
        <label for="email">Email:</label>
        <span id="email"><?php echo $user_email; ?></span>
      </li>
    </ul>
  </section>