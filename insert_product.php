<?php 
include('dbcon.php');
if(isset($_POST['insert_products'])){
    $product_name=$_POST['product_name'];
    $product_category=$_POST['product_category'];
    $product_price=$_POST['product_price'];

    $product_image=$_FILES['product_image']['name'];
    $temp_image=$_FILES['product_image']['tmp_name'];
   
    if($product_name=='' or $product_category=='' or $product_price=='' or $product_image==''){
echo "<script>alert('Please fill all the available fields') </script>";
exit();
}else{
move_uploaded_file($temp_image,"./product_images/$product_image");

// insert query
$insert_products="INSERT INTO products (name, category_id,
price, image) VALUES ('$product_name','$product_category', '$product_price','$product_image')";

$result_query=mysqli_query($conn, $insert_products);
if($result_query){
echo "<script>alert('Successfully inserted')</script>";
}

}


}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
    <label for="product_name">Product title</label>
    <input type="text" name="product_name" id="product_name" placeholder="Enter product title" autocomplete="off" required="required">
    <select name="product_category" id="" class="form-select">
<option value=""> Select a Category</option>
<?php
$select_query="SELECT * FROM categories";
$result_query=mysqli_query($conn, $select_query);
while ($row=mysqli_fetch_assoc($result_query)){
$category_title=$row ['category_name'];
$category_id=$row ['category_id'];
echo "<option value='$category_id'>$category_title</option>";

}
?>
    
    <label for="price">Price</label>
    <input type="text" name="product_price" id="product_price" placeholder="Enter product price" autocomplete="off" required="required">
    <label for="product_image">Image</label>
    <input type="file" name="product_image" id="product_image" placeholder="Upload Image"  required="required">
    <input type="submit" name="insert_products">





    </form>
</body>
</html>