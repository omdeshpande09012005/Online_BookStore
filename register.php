<?php
include "includes/config.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['firstname'];
    $lastName  = $_POST['lastname'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $address   = $_POST['address'];
    $password  = $_POST['password'];

    // Hash the password for basic security.
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO Customers (FirstName, LastName, Email, Phone, Address, Password)
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$address', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        $success = "🎉 Sign up successful!";
    } else {
        $error = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Sign Up | OnlineBookstore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Overall Body with Amazing Gradient Background */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff6f61, #3498db, #27ae60, #8e44ad);
            background-size: 400% 400%;
            animation: gradientShift 12s ease infinite;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            color: #fff;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        
        /* Header Image Styling */
        .header-image img {
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }

        /* Registration Card with Dark Glassmorphism */
        .register-card {
            background: rgba(0, 0, 0, 0.8);  /* Dark translucent background */
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 12px;
            width: 90%;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.8);
        }

        .register-card h2 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #fff;
        }

        .msg {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Input Group Styling with Icons */
        .input-group {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .input-group i {
            margin-right: 10px;
            font-size: 18px;
            color: #fff;
        }

        .input-group input,
        .input-group textarea {
            border: none;
            background: transparent;
            width: 100%;
            font-size: 16px;
            color: #fff;
            outline: none;
        }

        ::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        /* Button Styling for Sign Up */
        .btn {
            background: #f1c40f;
            color: #000;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 100%;
            border: none;
            margin-top: 10px;
        }
        .btn:hover {
            background: #e1b50f;
        }
        
        /* Proceed to Sign In Button Style */
        .btn-signin {
            background: transparent;
            color: #f1c40f;
            border: 2px solid #f1c40f;
            margin-top: 15px;
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .btn-signin:hover {
            background: #f1c40f;
            color: #000;
        }
    </style>
</head>
<body>
    <!-- Header Image -->
    <div class="header-image">
        <img src="https://source.unsplash.com/600x200/?abstract,gradient" alt="Creative Registration Illustration">
    </div>

    <!-- Registration Card -->
    <div class="register-card">
        <h2>Sign Up as a Customer</h2>

        <?php if ($success) echo "<p class='msg' style='color:#2ecc71;'>$success</p>"; ?>
        <?php if ($error) echo "<p class='msg' style='color:#e74c3c;'>$error</p>"; ?>

        <form method="post">
            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="firstname" placeholder="First Name" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="lastname" placeholder="Last Name" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-phone"></i>
                <input type="text" name="phone" placeholder="Phone">
            </div>

            <div class="input-group">
                <i class="fa-solid fa-map-marker-alt"></i>
                <textarea name="address" placeholder="Address"></textarea>
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="btn">Sign Up</button>
        </form>

        <!-- Proceed to Sign In Button -->
        <a href="login.php" class="btn-signin">Sign In</a>
    </div>
</body>
</html>
