<?php
include('dbcon.php');
session_start();

// Check if customer is logged in, if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to your login page
    exit();
}

// Replace these variables with your actual database credentials


$user_id = $_SESSION['user_id'];

// Fetch customer's data from the database
$sql = "SELECT firstname, lastname FROM user WHERE user_id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_firstname = $row['firstname'];
    $user_lastname = $row['lastname'];
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
.about-section {
  padding: 50px;
  text-align: center;
  background-color: #292726;
  color: white;
}

* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  
}
body {
  background-color: #f5f5f5;
}
.row-about {
  display: flex;
  flex-wrap: wrap;
  padding: 2em 1em;
  text-align: center;
}
.columna {
  width: 100%;
  padding: 0.5em 0;
}
h1 {
  width: 100%;
  text-align: center;
  font-size: 3.5em;
  color: #1f003b;
  border-radius: 15px;
  border: 7px solid #131212;
}



.carda {
  box-shadow: 0 0 2.4em rgba(25, 0, 58, 0.1);
  padding: 3.5em 1em;
  border-radius: 0.6em;
  color: #1f003b;
  cursor: pointer;
  transition: 0.3s;
  background-color: #ffffff;
}
.carda .img-container {
  width: 8em;
  height: 8em;
  background-color: #16141d;
  padding: 0.5em;
  border-radius: 50%;
  margin: 0 auto 2em auto;
}
.carda img {
  width: 100%;
  border-radius: 50%;
}
.carda h3 {
  font-weight: 500;
}
.carda p {
  font-weight: 300;
  text-transform: uppercase;
  margin: 0.5em 0 2em 0;
  letter-spacing: 2px;
}
.icons-about {
  width: 50%;
  min-width: 180px;
  margin: auto;
  display: flex;
  justify-content: space-between;
}
.carda a {
  text-decoration: none;
  color: inherit;
  font-size: 1.4em;
}
.carda:hover {
  background: linear-gradient(#504e4b, #f6f6f8);
  color: #131212;
}
.carda:hover .img-container {
  transform: scale(1.15);
}
@media screen and (min-width: 768px) {
  section {
    padding: 1em 7em;
  }
}
@media screen and (min-width: 992px) {
  section {
    padding: 1em;
  }
  .carda {
    padding: 5em 1em;
  }
  .columna {
    flex: 0 0 33.33%;
    max-width: 33.33%;
    padding: 0 1em;
  }
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
        <h1 style="border: none;">Login</h1>
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
</div>> -->
<div>
  <br>
  <br>
  <br>
</div>
<!-- abouts us na murag description -->
    <div class="about-section"> 
        <h1 class="about" style="color: #f5f5f5; border: none;">About Us</h1>
        <p style="margin-top: 20px;">Gadget Haven is your one-stop destination for the latest and most innovative gadgets. With a passion for technology and a commitment to quality, we aim to provide our customers with a seamless and unparalleled shopping experience. Our carefully curated collection includes cutting-edge smartphones, smart home devices, wearables, gaming consoles, and much more. At Gadget Haven, we believe that technology should not only simplify but also enrich your life. Our team of tech enthusiasts is dedicated to staying ahead of the curve, ensuring that you have access to the most advanced and trendsetting products on the market. Join us on this exciting journey of discovery and empowerment through the world of gadgets.</p>
     
      </div>



      <!-- about us  -->
    <section>
        <div class="row-about">
          <h1>Our Team</h1>
        </div>
        <div class="row-about">
          <!-- Column 1-->
          <div class="columna">
            <div class="carda">        <!--cards para sa picture,name og info-->
              <div class="img-container">
                <img src="About/kilat.png" />
              </div>
              <h3>Regine Kilat</h3>
              <p>DESIGNER</p>
              <!-- icons -->
              <div class="icons-about">
                <a href="https://www.facebook.com/RegineTubioKilat">
                  <i class="fa fa-facebook"></i>
                </a>
                <a href="https://l.messenger.com/l.php?u=https%3A%2F%2Fwww.instagram.com%2Freginetkilat%3Figsh%3DMTNiYzNiMzkwZA%253D%253D&h=AT1Epg0CIdj7mMY8OyqT0rR0oENh6ulslBqwiyjwzpxi8VMZz_Mkzrb7iszQlez2G4_wTsd3MZpke_l9elqMnZtE2bR33JvnoO-XU8zq7wteGGJKtV-t9qvn8jnG291j4A8Xym-nD0RF0GNpCey8bg">
                  <i class="fa fa-instagram"></i>
                </a>
               
                <a href="toocoolforscool09@gmail.com">
                  <i class="fa fa-envelope"></i>
                </a>
              </div>
            </div>
          </div>
          <!-- Column 2-->
          <div class="columna">
            <div class="carda">
              <div class="img-container">
                <img src="About/daniel.jpg" />
              </div>
              <h3>Daniel Banaybanay</h3>
              <p>Programmer</p>
              <div class="icons-about">
                <a href="https://www.facebook.com/profile.php?id=100037086212790">
                  <i class="fa fa-facebook"></i>
                </a>
                <a href="#">
                  <i class="fa fa-instagram"></i>
                </a>
               
                <a href="#">
                  <i class="fa fa-envelope"></i>
                </a>
              </div>
            </div>
          </div>
          <!-- Column 3-->
          <div class="columna">
            <div class="carda">
              <div class="img-container">
                <img src="About/raga.png" />
              </div>
              <h3>Christine Marie Raga</h3>
              <p>Designer</p>
              <div class="icons-about">
                <a href="https://www.facebook.com/Chixx.Raga">
                  <i class="fa fa-facebook"></i>
                </a>
                <a href="https://l.messenger.com/l.php?u=https%3A%2F%2Fwww.instagram.com%2Ftinee_rags%3Figsh%3DMTNiYzNiMzkwZA%253D%253D&h=AT1Epg0CIdj7mMY8OyqT0rR0oENh6ulslBqwiyjwzpxi8VMZz_Mkzrb7iszQlez2G4_wTsd3MZpke_l9elqMnZtE2bR33JvnoO-XU8zq7wteGGJKtV-t9qvn8jnG291j4A8Xym-nD0RF0GNpCey8bg">
                  <i class="fa fa-instagram"></i>
                </a>
               
                <a href="#">
                  <i class="fa fa-envelope"></i>
                </a>
              </div>
            </div>
          </div>
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
        
        <script src="script.js"></script>
    </body>
    </html>
    
