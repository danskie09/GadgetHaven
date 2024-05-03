<?php

include 'dbcon.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';
function shortenText($text, $maxLength) {
    if (strlen($text) > $maxLength) {
        $shortenedText = substr($text, 0, $maxLength) . '...';
    } else {
        $shortenedText = $text;
    }
    return $shortenedText;
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
  <title>Cart</title>
  
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
            <a href="order.php" style="color:black; "></a>Orders<sup><?= $total_order_counts; ?></sup></a>
            <a href="cart.php"><i class='fa fa-shopping-cart' ></i><sup><?= $total_cart_counts; ?></sup></a>
            <a href="#"><i class='fa fa-user' ></i></a>
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true" ></i></a>
            
        </div>
    </header>  

<body>


<div class="smartphone">
    <h1 class="slide-in-left" style="font-size: 50px; margin-top: 60px;">ORDERS</h1>
    
  
</div>


<section class="orders">

   

   <div class="box-container">

   <?php
      if ($user_id == '') {
         echo '<p class="empty">please login to see your orders</p>';
      } else {
        $sql = "SELECT firstname, lastname, email FROM user WHERE user_id = $user_id";
        $result = mysqli_query($conn, $sql);
        
        // Check if the query was successful
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $firstname = isset($user_data['firstname']) ? $user_data['firstname'] : '';
            $lastname = isset($user_data['lastname']) ? $user_data['lastname'] : '';
            $email = isset($user_data['email']) ? $user_data['email'] : '';
        } else {
            // Handle the case when the user data is not found
            $firstname = '';
            $lastname = '';
            $email = '';
        }
         $select_orders_query = "SELECT * FROM `orders` WHERE user_id = '$user_id'";
         $select_orders_result = mysqli_query($conn, $select_orders_query);

         if ($select_orders_result && mysqli_num_rows($select_orders_result) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders_result)) {
   ?>
   <div class="box">
<br>

      <p>Placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Name : <span><?= $firstname . ' ' . $lastname ?></span></p>

     
      <p>Email : <span><?= $email?></span></p>
      
      <p>Address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>Payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>Your orders: <span><?= shortenText($fetch_orders['total_products'], 50); ?></span></p>

      <p>Total price : <span>P <?= $fetch_orders['total_price']; ?>/-</span></p>
      <p> Payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){ echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
            }
         } else {
            echo '<p class="empty">no orders placed yet!</p>';
         }
      }
   ?>

   </div>

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
<style>
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
header .logo {
    float:left;
    width: 220px;
    height: 220px;
    display: block; /* Ensure it's a block-level element for centering */
   
}
.orders{
   padding: 10px 5%;
}
.box-container{
   margin-top: 10px;
   display: grid;
   grid-template-columns: repeat(auto-fit,minmax(320px, 1fr));
  column-gap: 10px;
justify-content: center;
text-align: center;
}

 .box-container .box {
   width: 300px;
   height: 300px;
  background: #f5f5f5;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
  border: 1px  black;
  border-radius: 10px;
  padding: 20px 10px;
  margin: 5px;
  margin-bottom: 20px;
  }

  .box-container .box p{
    font-weight: normal;
  }
  .box-container .box span{
    font-weight: 300;
  }



</style>

</body>
</html>
