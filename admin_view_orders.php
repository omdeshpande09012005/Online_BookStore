<?php
session_start();
include "includes/config.php";

// Ensure that the user is an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";
$filterResult = null;

// Check if form is submitted for filtering orders by customer
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the customer ID input
    $customerID = $_POST['customer_id'];
    
    // Call the stored procedure to get orders by customer ID
    $sql = "CALL GetOrdersByCustomer($customerID)";
    $filterResult = $conn->query($sql);
    
    // Flush any remaining results from the stored procedure call
    while ($conn->more_results() && $conn->next_result()) {;}

    if ($filterResult && $filterResult->num_rows > 0) {
        $message = "Orders for Customer ID: $customerID";
    } else {
        $message = "No orders found for Customer ID: $customerID";
    }
}

// Fetch all orders (this query assumes you have an Orders table with matching columns)
$allOrdersSQL = "SELECT OrderID, OrderDate, OrderStatus, TotalAmount FROM Orders ORDER BY OrderDate DESC";
$allOrdersResult = $conn->query($allOrdersSQL);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - View Orders</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #2c3e50;
            margin: 0;
            padding: 40px;
            color: #ECF0F1;
        }
        /* Main Container */
        .container {
            max-width: 900px;
            margin: auto;
            background: #34495e;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            padding: 30px;
        }
        /* Top Navigation */
        .topnav {
            margin-bottom: 20px;
        }
        .topnav a {
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
            margin-right: 15px;
        }
        .topnav a:hover {
            text-decoration: underline;
        }
        /* Headings */
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ECF0F1;
        }
        /* Form Styling */
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        form label {
            font-size: 16px;
            margin-right: 10px;
        }
        form input[type="number"] {
            padding: 8px;
            width: 150px;
            border: none;
            border-radius: 4px;
            margin-right: 10px;
        }
        form button {
            padding: 8px 16px;
            background: #27ae60;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        form button:hover {
            background: #229954;
        }
        /* Message Styling */
        .message {
            text-align: center;
            margin-bottom: 20px;
            font-size: 18px;
            color: #f1c40f;
        }
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #3d566e;
            border-radius: 6px;
            overflow: hidden;
        }
        th, td {
            padding: 14px;
            border-bottom: 1px solid #2c3e50;
            text-align: left;
            font-size: 15px;
        }
        th {
            background: #2980b9;
            color: #fff;
            font-weight: bold;
        }
        tr:hover {
            background: #4e6a85;
        }
        a.btn {
            background: #3498db;
            padding: 6px 12px;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s ease;
        }
        a.btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topnav">
            <a href="admin_dashboard.php">← Back to Dashboard</a>
        </div>

        <!-- Section: Show All Orders -->
        <h2>📦 All Orders</h2>
        <?php if ($allOrdersResult && $allOrdersResult->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Details</th>
                </tr>
                <?php while ($row = $allOrdersResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['OrderID']; ?></td>
                        <td><?php echo $row['OrderDate']; ?></td>
                        <td><?php echo $row['OrderStatus']; ?></td>
                        <td>₹<?php echo number_format($row['TotalAmount'], 2); ?></td>
                        <td><a class="btn" href="admin_order_details.php?order_id=<?php echo $row['OrderID']; ?>">View Items</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p style="text-align:center;">No orders found.</p>
        <?php endif; ?>

        <!-- Section: Filter Orders by Customer -->
        <h2 style="margin-top:40px;">🔍 Check Orders by Customer</h2>
        <form method="POST" action="admin_view_orders.php">
            <label>Enter Customer ID:</label>
            <input type="number" name="customer_id" required>
            <button type="submit">View Orders</button>
        </form>

        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (isset($filterResult) && $filterResult->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Total Amount</th>
                    <th>Details</th>
                </tr>
                <?php while ($row = $filterResult->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['OrderID']; ?></td>
                        <td><?php echo $row['OrderDate']; ?></td>
                        <td><?php echo $row['OrderStatus']; ?></td>
                        <td>₹<?php echo number_format($row['TotalAmount'], 2); ?></td>
                        <td><a class="btn" href="admin_order_details.php?order_id=<?php echo $row['OrderID']; ?>">View Items</a></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
