<?php
include('dbcon.php');
session_start();

// Check if the user is already logged in, redirect to homepage if true
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form inputs
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
  
    $password = $_POST['password'];
    $verifyPassword = $_POST['verify_password'];

    // Validate form inputs (add more validation as per your requirements)
    if (empty($firstname) || empty($lastname) || empty($email)  || empty($password) || empty($verifyPassword)) {
        $error = "All fields are required.";
    } elseif ($password !== $verifyPassword) {
        $error = "Passwords do not match.";
    } else {
       

        // Prepare and execute SQL statement to insert user into the database
        $stmt = $conn->prepare("INSERT INTO user (firstname, lastname, email, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $firstname, $lastname, $email, $password);
        if ($stmt->execute()) {
            $success = "Registration successful. You can now login.";
           
        } else {
            $error = "Error occurred. Please try again.";
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <!-- Google Font -->
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-image: url('home.png'); /* Set your background image here */
            background-size: cover;
            color: #333; /* Dark gray text */
            font-family: Arial, sans-serif;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(46, 45, 45, 0.7); /* Semi-transparent white overlay */
        }

        .signup-container {
            background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white container */
            color: #333; /* Dark gray text */
            border: 1px solid #ccc; /* Light gray border */
            border-radius: 5px;
            padding: 30px;
            width: 450px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1; /* Place the form above the overlay */
            
        }

        h2 {
            font-size: 28px;
            margin: 0;
        }

        form {
            margin-top: 20px;
            
        }

        label {
            display: block;
            margin-top: 10px;
            font-size: 16px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc; /* Light gray border */
            background-color: #f0f0f0; /* Light gray background */
            color: #333; /* Dark gray text */
            margin-top: 5px;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #333; /* Dark gray background */
            color: white; /* White text */
            border: none;
            padding: 10px 20px;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #555; /* Slightly darker gray on hover */
        }

        p {
            margin-top: 20px;
        }

        a {
            color: #333; /* Dark gray text */
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #555; /* Slightly darker gray on hover */
        }

        .signup-button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- para sa background -->
    <div class="overlay"></div>
    <div class="signup-container">
        <h2>Sign Up</h2>
<!-- form para sa signup -->

<?php 
if(isset($success)){?>
<p><?php echo $success; ?></p>
<?php }?>
        <form method="POST" action="">


            <label for="firstname">First Name:</label>
            <input type="text" name="firstname" required><br>

            <label for="lastname">Last Name:</label>
            <input type="text" name="lastname" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <label for="verify_password">Verify Password:</label>
            <input type="password" name="verify_password" required><br>

            <div class="signup-button-container">
                <input type="submit" value="Sign Up">
            </div>
        </form>

        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>
</html>



