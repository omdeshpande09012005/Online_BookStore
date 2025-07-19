<?php
session_start();
$orderID = isset($_SESSION['last_order_id']) ? $_SESSION['last_order_id'] : null;
unset($_SESSION['last_order_id']); // Optional: clear after use
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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            overflow-x: hidden;
            text-align: center;
            background: linear-gradient(-45deg, #ff6f61, #3498db, #27ae60, #8e44ad);
            background-size: 400% 400%;
            animation: gradientShift 12s infinite ease-in-out;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

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

        .box {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(15px);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(255,255,255,0.2);
        }
        h2 {
            font-size: 36px;
            color: #2ecc71;
            margin-bottom: 20px;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.4);
        }
        p {
            font-size: 18px;
        }
        .order-id {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 24px;
            background: #3498db;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            transition: background 0.3s ease;
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

<div class="box">
    <h2>✅ Order Placed Successfully!</h2>
    <p>Thank you for shopping with OnlineBookstore.</p>

    <?php if ($orderID): ?>
        <p class="order-id">📦 Your Order ID: <strong><?php echo $orderID; ?></strong></p>
    <?php else: ?>
        <p>Could not retrieve Order ID.</p>
    <?php endif; ?>

    <a class="btn" href="index.php">🏠 Back to Dashboard</a>
</div>

</body>
</html>
