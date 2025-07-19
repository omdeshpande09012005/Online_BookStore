<?php
session_start();
include "includes/config.php";

// Check login
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Check if cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='books.php'>Go back to books</a></p>";
    exit();
}

$customerID = $_SESSION['customer_id'];
$shippingAddress = "Default Shipping Address"; // Optional: collect from user
$trackingNumber = "TRK" . rand(1000, 9999);
$paymentMethod = "Cash on Delivery"; // You can change this later

$totalAmount = 0;
foreach ($_SESSION['cart'] as $item) {
    $totalAmount += $item['price'] * $item['quantity'];
}

// 1. Insert into Orders table
$orderSQL = "INSERT INTO Orders (CustomerID, OrderDate, OrderStatus, ShippingAddress, TrackingNumber, PaymentMethod, TotalAmount)
             VALUES ($customerID, NOW(), 'Placed', '$shippingAddress', '$trackingNumber', '$paymentMethod', $totalAmount)";

if ($conn->query($orderSQL) === TRUE) {
    $orderID = $conn->insert_id;

    // 2. Insert into OrderDetails
    foreach ($_SESSION['cart'] as $bookID => $item) {
        $qty = $item['quantity'];
        $price = $item['price'];

        $detailSQL = "INSERT INTO OrderDetails (OrderID, BookID, Quantity, Price)
                      VALUES ($orderID, $bookID, $qty, $price)";
        $conn->query($detailSQL);
    }

    // 3. Clear cart
    unset($_SESSION['cart']);
    $_SESSION['last_order_id'] = $orderID;
    header("Location: thank_you.php");
    exit();
} else {
    echo "Error placing order: " . $conn->error;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation | OnlineBookstore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Global Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            overflow-x: hidden;
            /* Animated Gradient Background */
            background: linear-gradient(-45deg, #ff6f61, #3498db, #27ae60, #8e44ad);
            background-size: 400% 400%;
            animation: gradientShift 12s infinite ease-in-out;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Navbar with Glassmorphism */
        header {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            padding: 15px 0;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .navbar {
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        .navbar .logo {
            font-size: 26px;
            font-weight: 600;
            color: white;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.4);
        }
        .navbar nav ul {
            display: flex;
            gap: 20px;
        }
        .navbar nav ul li a {
            font-size: 16px;
            color: white;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.4);
            transition: color 0.3s ease;
        }
        .navbar nav ul li a:hover {
            color: #f1c40f;
        }

        /* Order Confirmation Container */
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(15px);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(255,255,255,0.2);
            text-align: center;
        }
        h2 {
            font-size: 32px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.4);
        }
        .msg {
            color: #27ae60;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .order-details {
            font-size: 16px;
            margin-bottom: 15px;
        }
        .btn {
            background: #3498db;
            color: white;
            padding: 14px;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            margin-top: 20px;
            transition: background 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<header>
    <div class="navbar">
        <div class="logo">OnlineBookstore</div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="books.php">Browse Books</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container">
    <h2>✅ Order Placed Successfully!</h2>

    <p class="msg">Your order has been placed and is being processed.</p>

    <div class="order-details">
        <p><strong>Order ID:</strong> <?php echo $_SESSION['last_order_id']; ?></p>
        <p><strong>Tracking Number:</strong> <?php echo $trackingNumber; ?></p>
        <p><strong>Payment Method:</strong> Cash on Delivery</p>
    </div>

    <a class="btn" href="orders.php">📦 View My Orders</a>
</div>

</body>
</html>
