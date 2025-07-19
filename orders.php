<?php
session_start();
include "includes/config.php"; // Your DB connection file

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customerID = $_SESSION['customer_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Orders | OnlineBookstore</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    /* Global Reset and Base Styles */
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
    
    /* Container for Order Information (Glassmorphism style) */
    .container {
      max-width: 1000px;
      margin: 40px auto;
      background: rgba(255,255,255,0.15);
      backdrop-filter: blur(15px);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 6px 25px rgba(255,255,255,0.2);
    }
    
    /* Headings and Navigation Links */
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
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </div>
</header>

<div class="container">
  <h2>My Orders</h2>
  <div class="nav-links">
    <a href="index.php">⬅️ Back to Dashboard</a>
  </div>

  <table>
    <tr>
      <th>Order ID</th>
      <th>Order Date</th>
      <th>Status</th>
      <th>Total Amount (₹)</th>
      <th>Details</th>
    </tr>

    <?php
    $sql = "SELECT * FROM Orders WHERE CustomerID = $customerID ORDER BY OrderDate DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($order = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $order['OrderID'] . "</td>";
            echo "<td>" . $order['OrderDate'] . "</td>";
            echo "<td>" . $order['OrderStatus'] . "</td>";
            echo "<td>" . number_format($order['TotalAmount'], 2) . "</td>";
            echo "<td><a href='order_items.php?order_id=" . $order['OrderID'] . "' style='color:#f1c40f;'>View Items</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5' style='text-align:center;'>No orders found.</td></tr>";
    }
    ?>
  </table>
</div>

</body>
</html>
