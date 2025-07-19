<?php
session_start();
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
$cart = $_SESSION['cart'] ?? [];
$total = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Cart</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Animated Gradient Background */
        body {
            margin: 0;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #ff6f61, #3498db, #27ae60, #8e44ad);
            background-size: 400% 400%;
            animation: gradientShift 12s ease infinite;
            color: #f1f1f1;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Links & Headings */
        a, a:visited {
            color: #f1c40f;
            text-decoration: none;
        }
        h2 {
            color: #f1c40f;
            text-align: center;
        }

        /* Container with Glassmorphism Effect */
        .cart-container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(15px);
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.8);
        }

        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1f1f1f;
            margin-top: 20px;
            color: #fff;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            border-bottom: 1px solid #444;
            text-align: left;
        }
        th {
            background-color: #2c2c2c;
            color: #f1c40f;
        }
        tr:hover {
            background-color: #2a2a2a;
        }

        /* Button Styling */
        button {
            background-color: #f1c40f;
            border: none;
            padding: 8px 14px;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #e1b50f;
        }

        /* Centered Action Link */
        .action-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="cart-container">
        <h2>Your Shopping Cart</h2>
        <p>
            <a href="books.php">⬅️ Continue Browsing</a> | <a href="index.php">🏠 Dashboard</a>
        </p>
        <br>
        
        <?php if (empty($cart)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Book</th>
                    <th>Price (₹)</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($cart as $bookID => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['title']); ?></td>
                    <td><?php echo number_format($item['price'], 2); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo number_format($subtotal, 2); ?></td>
                    <td>
                        <form method="post" action="remove_from_cart.php" style="display:inline;">
                            <input type="hidden" name="book_id" value="<?php echo $bookID; ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td colspan="2"><strong>₹<?php echo number_format($total, 2); ?></strong></td>
                </tr>
            </table>
            <div class="action-link">
                <a href="place_order.php"><button>✅ Place Order</button></a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
