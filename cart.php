<?php
include('dbcon.php');

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:login.php');
}







if (isset($_POST['delete'])) {
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE cart_id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if (isset($_GET['delete_all'])) {
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['quantity'];
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE cart_id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
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
    <!-- header -->
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

<body>


<div class="smartphone">
    <h1 class="slide-in-left" style="font-size: 50px; margin-top: 60px;">CART</h1>
    
  
</div>
   <section class="cart">

  

      <div class="box-container">

         <?php
         $grand_total = 0;

         // Assuming $conn is your MySQLi connection object and $user_id is your user ID
         $user_id = $_SESSION['user_id']; // Replace this with the actual user ID

         $select_cart_query = "
    SELECT c.*, p.name AS product_name, p.price AS product_price, p.image AS image
    FROM `cart` c
    JOIN `products` p ON c.product_id = p.product_id
    WHERE c.user_id = ?
";
         $select_cart_stmt = $conn->prepare($select_cart_query);
         $select_cart_stmt->bind_param("i", $user_id); // Assuming user_id is an integer

         $select_cart_stmt->execute();
         $select_cart_result = $select_cart_stmt->get_result();

         if ($select_cart_result->num_rows > 0) {
            while ($fetch_cart = $select_cart_result->fetch_assoc()) {
         ?>
         
               <form action="" method="post" class="box">
                  <input type="hidden" name="cart_id" value="<?= $fetch_cart['cart_id']; ?>">
                  <img src="product_images/<?= $fetch_cart['image']; ?>">

                  <div class="name"><?= $fetch_cart['product_name']; ?></div>
                  <div class="flex">
                     <div class="price">P <?= $fetch_cart['product_price']; ?>/-</div>
                     <input type="number" name="quantity" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
                     <button type="submit" class="fa fa-edit" name="update_qty"></button>
                  </div>
                  <div class="sub-total"> sub total : <span>P <?= $sub_total = ($fetch_cart['product_price'] * $fetch_cart['quantity']); ?>/-</span> </div>
                  <input type="submit" value="Delete" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete" ><i class="fa fa-trash" aria-hidden="true"></i>
                  <br>
                  <br>
               </form>
         <?php
               $grand_total += $sub_total;
            }
         } else {
            echo '<p class="empty">your cart is empty</p>';
         }
         ?>
      </div>

      <div class="cart-total">
         <p>Grand Total : <span>P <?= $grand_total; ?>/-</span></p>
         <a href="test_products.php" class="btn">Continue Shopping</a>
         <a href="cart.php?delete_all" class="btn" <?= ($grand_total > 1) ? '' : 'disabled'; ?>" onclick="return confirm('delete all from cart?');">Delete all item</a>
         <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed to checkout</a>
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

.cart{
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
  background: #f5f5f5;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
  border-radius: 10px;
  padding: 5px;
  margin: 5px;
  margin-bottom: 20px;
  }

  .box img{
   height: 50%;
  width: 50%;

  }





 </style>

</body>

</html>