<?php
session_start();
include "includes/config.php";

// Ensure that the user is an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

// Validate Order ID from URL
if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
    $orderID = intval($_GET['order_id']);

    // Fetch order details using the stored procedure
    $sql = "CALL GetOrderDetails(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $message = "Details for Order ID: $orderID";
    } else {
        $message = "No items found for Order ID: $orderID";
    }
} else {
    $message = "Invalid order ID.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin - Order Details</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #2c3e50;
            margin: 0;
            padding: 40px;
            color: #ECF0F1;
        }
        /* Container with Glassmorphism-Inspired Dark Card */
        .container {
            max-width: 900px;
            margin: auto;
            background: rgba(52, 73, 94, 0.85);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.4);
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
        /* Heading */
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ECF0F1;
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
            background: #34495e;
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
            background: #40739e;
        }
        /* Button Styling */
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
            <a href="admin_view_orders.php">← Back to Orders</a>
        </div>
        <h2>📚 Order Details</h2>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if (isset($result) && $result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>ISBN</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['BookID']; ?></td>
                        <td><?php echo $row['Title']; ?></td>
                        <td><?php echo $row['Author']; ?></td>
                        <td><?php echo $row['Publisher']; ?></td>
                        <td><?php echo $row['ISBN']; ?></td>
                        <td><?php echo $row['Quantity']; ?></td>
                        <td>₹<?php echo number_format($row['Price'], 2); ?></td>
                        <td>₹<?php echo number_format($row['Total'], 2); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
