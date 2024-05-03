<?php

include 'dbcon.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['send'])) {

    $name = $_POST['name'];
    
    $email = $_POST['email'];
   
    $number = $_POST['number'];
    $msg = $_POST['msg'];
    

    $select_message_query = "SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?";
    $select_message_stmt = mysqli_prepare($conn, $select_message_query);
    mysqli_stmt_bind_param($select_message_stmt, "ssss", $name, $email, $number, $msg);
    mysqli_stmt_execute($select_message_stmt);
    $select_message_result = mysqli_stmt_get_result($select_message_stmt);

    if (mysqli_num_rows($select_message_result) > 0) {
        $message = 'Already sent message!';
    } else {

        $insert_message_query = "INSERT INTO `messages` (user_id, name, email, number, message) VALUES (?, ?, ?, ?, ?)";
        $insert_message_stmt = mysqli_prepare($conn, $insert_message_query);
        mysqli_stmt_bind_param($insert_message_stmt, "issss", $user_id, $name, $email, $number, $msg);
        mysqli_stmt_execute($insert_message_stmt);

        $message = 'Sent message successfully!';
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    
 

<!--GOOGLE FONTS-->

<!-- Google Font -->
<link
href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap"
rel="stylesheet"
/>
<link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Play&display=swap" rel="stylesheet"> 
<link rel="stylesheet"
  href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
   
    .banner {
    text-align: center;
    background-color: #ffffff;
    margin: 0 auto;
}
 
.banner img {
    max-width: 150%;
    height: auto;
}
/* Contact form styles */
.contact-form {
    padding: 40px 0;
    margin: 0 10px;
}
 
.form-container-1 {
    max-width: 40%;
    margin: 0 auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}
 
.contact-form h2 {
    text-align: center;
    margin-bottom: 20px;
}
 
.form-group {
    margin-bottom: 20px;
}
 
.form-container-1 label {
    display:block;
    font-weight: bold;
}
.form-container-1 input, textarea{
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 1rem;
    resize: vertical;
}
.submit-button {
    padding: 10px 20px;
    background-color: #121312;
    border: none;
    color: white;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    width: 100%;
  
  margin-top: 15px;
  background-color: #0d0d0e;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
}

.submit-button:hover{
  background-color: #969c9a;
}
 
/* Contact info styles */
.contact-info {
    text-align: center;
    padding: 50px 0;
    background-color: #f7f7f7;
}
 
.contact-info h2 {
    margin-bottom: 20px;
}
header{
	width: 100%;
	top: 0;
	right: 0;
	z-index: 1000;
	position: fixed;
	background: var(--bg-color);
	box-shadow: 0px 14px 18px 0 rgba(0, 0, 0, 0.2);
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 20px 8%;
	transition: .3s;
    box-sizing: border-box;
    height: 70px;
}
.logo {
    float:left;
    width: 220px;
    height: 220px;
    display: block;
}


</style>


    <title>Homepage</title>
</head>
<body>
<header>
    <?php
    
    // Assuming $conn is your MySQLi connection object and $user_id is your user ID
    $user_id = $_SESSION['user_id']; // Replace this with the actual user ID
    
    $count_cart_items_query = "SELECT * FROM `cart` WHERE user_id = ?";
    $count_cart_items_stmt = $conn->prepare($count_cart_items_query);
    $count_cart_items_stmt->bind_param("i", $user_id); // Assuming user_id is an integer
    
    $count_cart_items_stmt->execute();
    $count_cart_items_stmt->store_result();
    $total_cart_counts = $count_cart_items_stmt->num_rows;

    $count_order_items_query = "SELECT * FROM `orders` WHERE user_id = ?";
    $count_order_items_stmt = $conn->prepare($count_order_items_query);
    $count_order_items_stmt->bind_param("i", $user_id); // Assuming user_id is an integer
    
    $count_order_items_stmt->execute();
    $count_order_items_stmt->store_result();
    $total_order_counts = $count_order_items_stmt->num_rows;

    
    // Now $total_cart_counts contains the number of rows
    ?>
    <img src="images/gadgithbin.png" alt="" class="logo">
    
        <ul class="navbar">
            <li><a href="index.php">Home</a></li>
            <li><a href="test_products.php">Products</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="aboutUs.php">About Us</a></li>
        </ul>
    
        <div class="icons">
            <a href="order.php" style="color:black; ">Orders<sup><?= $total_order_counts; ?></sup></a>
            <a href="cart.php"><i class='fa fa-shopping-cart' ></i><sup><?= $total_cart_counts; ?></sup></a>
            <!-- <a href="#"><i class='fa fa-user' ></i></a> -->
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true" ></i></a>
            
        </div>
    </header>  

    <!-- <div class="form-popup" id="myForm">
        <form action="/action_page.php" class="form-container">
            <h1>Login</h1>
            <label for="email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="email" required>
            <label for="psw"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="psw" required>
            <button type="submit" class="btn">Login</button>
            <button type="button" class="btn cancel" onclick="closeForm()">Close</button>
            <div class="container signup">
                <p>Don't have an account? <a href="signup.html">Signup</a>.</p>
            </div>
            <div class="External">
                <button class="facebook"><i class="fa fa-facebook"></i></button>
                <button class="google"><i class="fa fa-google"></i></button>
            </div>
        </form>
    </div> -->

    <div>
        <br>
        <br>
        <br>
        <br> 
     </div>



    <section class="banner">
        <img src=
"About/Contact us.png"
            alt="Welcome to our Contact Us page">
        <h1>Get in Touch With Us</h1>
        <p>We're here to answer any questions you may have.</p>
    </section>
 
    <!-- Contact form -->
    <section class="contact-form">
        <div class="form-container-1">
        <?php 
if(isset($message)){?>
<p><?php echo $message; ?></p>
<?php }?>
            <h2>Your Details</h2>
            <form action="#" method="POST">
 
                <label for="name">Name: </label>
                <input type="text" id="name" name="name" required>
 
                <label for="email">Email: </label>
                <input type="email" id="email" name="email" required>
 
                <label for="phone">Phone: </label>
                <input type="text" id="number" name="number">
 
                <label for="message">Message: </label>
                <textarea id="message" name="msg" rows="4" required></textarea>
 
                <button type="submit" class="submit-button" name="send">Submit</button>
            </form>
        </div>
    </section>
 
    <!-- Company contact info -->
    <section class="contact-info">
        <h2>Contact Information</h2>
        <address>
            Gadget Haven: Electronics and Gadgets<br>
            123 Main Street<br>
            Dumaguete City 6200<br>
            Phone: <a href="tel:1234567890">09350719369</a><br>
            Email: <a href="mailto:info@example.com">gadgethaven@gmail.com</a>
        </address>
    </section>














    <footer>
        <div class="footer">
        <div class="row">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
        
        <a href="#"><i class="fa fa-twitter"></i></a>
        </div>
        
        <div class="row">
        <ul>
        <li><a href="#">Contact us</a></li>
        <li><a href="#">Our Services</a></li>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Terms & Conditions</a></li>
       
        </ul>
        </div>
        
        <div class="row">
         © 2023 Gadget Haven - All rights reserved
        </div>
        </div>
        </footer>  
        
        <script src="script.js"></script>
    </body>
    </html>
    
