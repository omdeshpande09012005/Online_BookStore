<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customerID = $_SESSION['customer_id'];

if (!isset($_GET['order_id'])) {
    echo "<p style='color:red; font-size:18px;'>❌ No order selected.</p>";
    exit();
}

$orderID = intval($_GET['order_id']);

// Verify this order belongs to the logged-in customer
$orderCheck = $conn->query("SELECT * FROM Orders WHERE OrderID = $orderID AND CustomerID = $customerID");
if ($orderCheck->num_rows == 0) {
    echo "<p style='color:red; font-size:18px;'>⚠️ This order doesn't belong to you.</p>";
    exit();
}

// Fetch ordered books
$sql = "SELECT b.BookID, b.Title, od.Quantity, od.Price, (od.Quantity * od.Price) AS SubTotal
        FROM OrderDetails od
        JOIN Books b ON od.BookID = b.BookID
        WHERE od.OrderID = $orderID";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order #<?php echo $orderID; ?> Items | OnlineBookstore</title>
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

        /* Container for Order Details */
        .container {
            max-width: 1000px;
            margin: 40px auto;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(15px);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(255,255,255,0.2);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 36px;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.4);
        }
        .nav-links {
            text-align: center;
            margin-bottom: 30px;
            font-size: 16px;
            font-weight: 500;
        }
        .nav-links a {
            margin: 0 15px;
            color: #f1c40f;
            transition: color 0.3s ease;
        }
        .nav-links a:hover {
            color: #e1b50f;
        }

        /* Styled Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.3);
        }
        th {
            background: rgba(0,0,0,0.2);
            font-size: 18px;
        }
        tr:hover {
            background: rgba(0,0,0,0.1);
        }

        /* Action Button */
        .btn {
            background: #3498db;
            color: white;
            padding: 10px;
            border-radius: 6px;
            text-decoration: none;
            display: inline-block;
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
                <li><a href="books.php">Browse Books</a></li>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container">
    <h2>📦 Order #<?php echo $orderID; ?> - Items</h2>
    <div class="nav-links">
        <a href="orders.php">⬅️ Back to My Orders</a>
    </div>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Title</th>
                <th>Quantity</th>
                <th>Price (₹)</th>
                <th>Subtotal (₹)</th>
                <th>Action</th>
            </tr>

            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['Title']); ?></td>
                    <td><?php echo $row['Quantity']; ?></td>
                    <td><?php echo number_format($row['Price'], 2); ?></td>
                    <td><?php echo number_format($row['SubTotal'], 2); ?></td>
                    <td>
                        <a class="btn" href="add_review.php?book_id=<?php echo $row['BookID']; ?>">📝 Write Review</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <p style="text-align:center;">No items found for this order.</p>
    <?php endif; ?>
</div>

</body>
</html>
