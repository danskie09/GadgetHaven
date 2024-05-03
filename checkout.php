<?php

include ('dbcon.php');

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:login.php');
    exit(); // Terminate script after redirect
}

if (isset($_POST['order'])) {

    $firstname = $_POST['firstname'];
             $lastname = $_POST['lastname'];
             $email = $_POST['email'];
    $method = $_POST['method'];
    $uploaded = $_POST['uploaded'];

    $address = $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] ;

    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $check_cart_query = "SELECT * FROM `cart` WHERE user_id = ?";
    $check_cart_stmt = $conn->prepare($check_cart_query);
    $check_cart_stmt->bind_param("i", $user_id);
    $check_cart_stmt->execute();
    $check_cart_result = $check_cart_stmt->get_result();

   // ...

   if ($check_cart_result->num_rows > 0) {
      $insert_order_query = "INSERT INTO `orders` (user_id, method, gcash,  address, total_products, total_price, placed_on, payment_status) VALUES (?, ?,?, ?, ?, ?, ?, 'pending')";
  
      $payment_status = 'pending';
      $placed_on = date("Y-m-d H:i:s");
  
      $insert_order_stmt = $conn->prepare($insert_order_query);
      $insert_order_stmt->bind_param("issssis", $user_id, $method, $uploaded, $address, $total_products, $total_price, $placed_on);
  
      // Execute the order insertion query only once
      $order_inserted = $insert_order_stmt->execute();
  
      if ($order_inserted) {
          // Delete cart only if the order was inserted successfully
          $delete_cart_query = "DELETE FROM `cart` WHERE user_id = ?";
          $delete_cart_stmt = $conn->prepare($delete_cart_query);
          $delete_cart_stmt->bind_param("i", $user_id);
          $cart_deleted = $delete_cart_stmt->execute();
  
          if ($cart_deleted) {
            $message[] = 'Order placed successfully!';
            echo '<script>alert("Order placed successfully!");</script>';
          } else {
              $message[] = 'Failed to delete cart items';
          }
      } else {
          echo "Error: " . $insert_order_stmt->error;
          $message[] = 'Failed to place the order';
      }
  } else {
      $message[] = 'Your cart is empty';
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
            <a href="order.php" style="color:black; ">Orders<sup><?= $total_order_counts; ?></sup></a>
            <a href="cart.php"><i class='fa fa-shopping-cart' ></i><sup><?= $total_cart_counts; ?></sup></a>
            <!-- <a href="#"><i class='fa fa-user' ></i></a> -->
            <a href="logout.php"><i class="fa fa-sign-out" aria-hidden="true" ></i></a>
            
        </div>
    </header>    
    <div class="smartphone">
    <h1 class="slide-in-left" style="font-size: 50px; margin-top: 60px;">CHECKOUT</h1>
    
  
</div>

<section class="checkout-orders">

   <form action="" method="POST" class="orders">
 
   

      <div class="display-orders">
      <h3>Your Orders:</h3>
      <?php
         $grand_total = 0;
         $cart_items = array(); // Initialize as an empty array
         $select_cart_query = "
    SELECT c.*, p.name AS product_name, p.price AS product_price
    FROM `cart` c
    JOIN `products` p ON c.product_id = p.product_id
    WHERE c.user_id = ?
";
         $select_cart_stmt = $conn->prepare($select_cart_query);
         $select_cart_stmt->bind_param("i", $user_id);
         $select_cart_stmt->execute();
         $select_cart_result = $select_cart_stmt->get_result();

         if ($select_cart_result->num_rows > 0) {
            while ($fetch_cart = $select_cart_result->fetch_assoc()) {
               $cart_items[] = $fetch_cart['product_name'].' ('.$fetch_cart['product_price'].' x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['product_price'] * $fetch_cart['quantity']);
      ?>
         <p> <?= $fetch_cart['product_name']; ?> <span class="span-display">(<?= 'P '.$fetch_cart['product_price'].'/- x '. $fetch_cart['quantity']; ?>)</span> </p>
      <?php
            }
         } else {
            echo '<p class="empty">your cart is empty!</p>';
         }
      ?>

         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
         <div class="grand-total" style="font-weight: bold;">Total Amount: <span>P <?= $grand_total; ?>.00</span></div>
      </div>
      

      

      <div class="flex">
      <h3>Place your orders</h3>
         <?php 
         $sql = "SELECT firstname, lastname,email  FROM user WHERE user_id = $user_id";
         $result = $conn->query($sql);
         
         // Check if the query was successful
         if ($result && $result->num_rows > 0) {
             $user_data = $result->fetch_assoc();
             $firstname = $user_data['firstname'];
             $lastname = $user_data['lastname'];
             $email = $user_data['email'];

         } else {
             // Handle the case when the user data is not found
             $firstname = '';
             $lastname = '';
             $email = '';
         }
         
         ?>
         <span class="names">First Name:</span>
      <input type="text" id="firstname" name="firstname" value="<?= $firstname ?>" readonly>

      <span class="names">Last Name:</span>
      <input type="text" id="lastname" name="lastname" value="<?= $lastname ?>" readonly>

      <span style="left: 0;">Email:</span>
      <input type="email" id="email" name="email" value="<?= $email ?>" readonly>


         
            <div class="left">
            <span>Mode of Payment:</span>
            <select name="method" id="modeofPayment" class="box"  onchange="daniel()" required>
               <option value="cash on delivery">Cash on Delivery</option>
               <option value="gcash" id="gcash" >Gcash</option>
               
            </select>
         
         
         <div class="imageContainer" id="imgContainer" style="display: none";>
         <label for="QR CODE">Scan QR Code:</label>
            <img src="images/qrcode.jpg" alt="QR Code">
         <div class="text">Upload Screenshot:</div>
         <input type="file" name="uploaded" placeholder="Upload Screenshot" style="width: 100%;">
         </div>

            
        
         <span>Street :</span>
            <input type="text" name="street" placeholder="e.g. street name"  maxlength="50" required>
      
         
            <span>City :</span>
            <input type="text" name="city" placeholder="e.g. city name"  maxlength="50" required>
      
            <span>Province:</span>
            <input type="text" name="state" placeholder="e.g. province name"  maxlength="50" required>
         
           
         
            <span>Country :</span>
            <input type="text" name="country" placeholder="e.g. Philippines" class="box" maxlength="50" required>
            
         </div>
      
         <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="Place Order">
      </div>
     
      

   </form>

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












<script>
   
   

function daniel(){

            // Your condition or code here when the select element is clicked
            var img = document.getElementById('imgContainer').style.display="block";
       

var payment = document.getElementById('modeofPayment').value;

switch(payment){
   case 'cash on delivery':
      document.getElementById('imgContainer').style.display="none";
break;
      case 'Gcash':
         document.getElementById('imgContainer').style.display="block";
break;

default:
break;


}

}


</script>
<style>
.imageContainer{
   width: 400px;
   padding: 10px 10px;

}


.imageContainer img{
width: 100px;
height: 100px;

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
header .logo {
    float:left;
    width: 220px;
    height: 220px;
    display: block; /* Ensure it's a block-level element for centering */
   
}

section{
   padding: 10px 10%;
}
.display-orders{
width: 100%;
float: left;
height: 100%;
text-align: center;
justify-content: center;
background: #f5f5f5;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
  border-radius: 10px;
  padding: 5px;
  margin: 5px;
  margin-bottom: 100px;
}

.span-display{
   color: red;
}



   
   section .flex {
    display: flex;
    flex-direction: column; /* Align items vertically */
    justify-content: center; /* Center items horizontally */
    align-items: center; /* Center items vertically */
    max-width: 500px; /* Set your desired max-width */
    width: 100%;
    margin: 0 auto; /* Center horizontally */
    height: 100vh;

margin-top: 60px;
margin-bottom: 100px;
}

    

    

    

    input,
select {
    width: 100%;
    padding: 8px;
    box-sizing: border-box;
    margin-bottom: 10px;
}

    



</style>

</body>
</html>