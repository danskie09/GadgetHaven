<?php 
include('dbcon.php');
// include('functions.php');
session_start();

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
    <title>Products</title>
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

   
        <div class="smartphone">
            <h1  class="slide-in-left" style="font-size: 50px;">SMARTPHONES</h1>
            
          
        </div>
   
        
        
        
        
        
        </div>


<section class="sec">
    <div class="product-p">

    <?php
include('dbcon.php');


if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
 

    // Check if the product is already in the cart
    $check_query = "SELECT * FROM cart WHERE product_id = $product_id AND user_id = $user_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('This item is already present in the cart');</script>";
    } else {
        // Product is not in the cart, add it
        $insert_query = "INSERT INTO cart (product_id, user_id, quantity) VALUES ($product_id, $user_id,1)";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            
            header ("location: cart.php");
        } else {
            echo "<script>alert('Error adding item to the cart');</script>";
        }
    }

    // Redirect back to the product page (adjust the URL as needed)
    echo "<script>window.location.href = 'test_products.php';</script>";
}}
$select_query = "SELECT * FROM products WHERE category_id = 1 ORDER BY rand()";
$result_query = mysqli_query($conn, $select_query);

while ($row = mysqli_fetch_assoc($result_query)) {
    $product_id = $row['product_id'];
    $product_name = $row['name'];
    $product_price = $row['price'];
    $product_image = $row['image'];

    echo "<div class='card'>
              <div class='img'><img src='./product_images/$product_image' alt=''></div>
              <div class='product-title'>$product_name</div>
              <div class='product-price'><span>P </span>$product_price<span>.00</span></div>
              <div class='box'>
                  <a href='test_products.php?add_to_cart=$product_id' class='add'>Add to cart</a>
              </div>
          </div>";

          
}
?>



    






</section>


<div class="smartphone">
    <h1  class="slide-in-left" style="font-size: 50px;">LAPTOPS</h1>
    
  
</div>




<section class="sec">
    <div class="product-p">

    <?php
include('dbcon.php');


if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
   

    // Check if the product is already in the cart
    $check_query = "SELECT * FROM cart WHERE product_id = $product_id AND user_id = $user_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('This item is already present in the cart');</script>";
    } else {
        // Product is not in the cart, add it
        $insert_query = "INSERT INTO cart (product_id, user_id, quantity) VALUES ($product_id, $user_id,1)";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            echo "<script>alert('Item added to the cart');</script>";
        } else {
            echo "<script>alert('Error adding item to the cart');</script>";
        }
    }

    // Redirect back to the product page (adjust the URL as needed)
    echo "<script>window.location.href = 'test_products.php';</script>";
}}
$select_query = "SELECT * FROM products WHERE category_id = 2 ORDER BY rand()";
$result_query = mysqli_query($conn, $select_query);

while ($row = mysqli_fetch_assoc($result_query)) {
    $product_id = $row['product_id'];
    $product_name = $row['name'];
    $product_price = $row['price'];
    $product_image = $row['image'];

    echo "<div class='card'>
              <div class='img'><img src='./product_images/$product_image' alt=''></div>
              <div class='product-title'>$product_name</div>
              <div class='product-price'><span>P </span>$product_price<span>.00</span></div>
              <div class='box'>
                  <a href='test_products.php?add_to_cart=$product_id' class='add'>Add to cart</a>
              </div>
          </div>";

          
}
?>


    






</section>





</div>




















<div class="smartphone">
    <h1 class="slide-in-left" style="font-size: 50px;">ACCESSORIES</h1>
    
  
</div>

<section class="sec">
    <div class="product-p">

    <?php
include('dbcon.php');


if (isset($_GET['add_to_cart'])) {
    $product_id = $_GET['add_to_cart'];

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
 

    // Check if the product is already in the cart
    $check_query = "SELECT * FROM cart WHERE product_id = $product_id AND user_id = $user_id";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('This item is already present in the cart');</script>";
    } else {
        // Product is not in the cart, add it
        $insert_query = "INSERT INTO cart (product_id, user_id, quantity) VALUES ($product_id, $user_id,1)";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            echo "<script>alert('Item added to the cart');</script>";
        } else {
            echo "<script>alert('Error adding item to the cart');</script>";
        }
    }

    // Redirect back to the product page (adjust the URL as needed)
    echo "<script>window.location.href = 'test_products.php';</script>";
}}
$select_query = "SELECT * FROM products WHERE category_id = 3 ORDER BY rand()";
$result_query = mysqli_query($conn, $select_query);

while ($row = mysqli_fetch_assoc($result_query)) {
    $product_id = $row['product_id'];
    $product_name = $row['name'];
    $product_price = $row['price'];
    $product_image = $row['image'];

    echo "<div class='card'>
              <div class='img'><img src='./product_images/$product_image' alt=''></div>
              <div class='product-title'>$product_name</div>
              <div class='product-price'><span>P </span>$product_price<span>.00</span></div>
              <div class='box'>
                  <a href='test_products.php?add_to_cart=$product_id' class='add'>Add to cart</a>
              </div>
          </div>";

          
}
?>


    






</section>





</div>









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

.product-p .card {
  width: 100%;
  background: #f5f5f5;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
  border-radius: 20px;
  padding: 5px;
  margin: 5px;
  margin-bottom: 20px;
  transition: transform 0.3s ease; /* Add a transition for smooth effect */
}

.product-p .card:hover {
  transform: scale(1.05); /* Increase the size on hover */
  
}





.product-p .card img{
  height: 300px;
  width: 100%;
}
.product-p{
  display: grid;
  grid-template-columns: repeat(auto-fit,minmax(320px, 1fr));
  column-gap: 10px;
justify-content: center;
text-align: center;
}
 </style>
        <script src="script.js"></script>
</body>
</html>