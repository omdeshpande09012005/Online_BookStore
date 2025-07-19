<?php
session_start();
include "includes/config.php";

// Ensure the session is active and the customer ID exists
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

$customerID = $_SESSION['customer_id'];

// Call the stored procedure with the correct argument
$sql = "CALL GetOrdersByCustomer($customerID)";
$result = $conn->query($sql);

// Output orders
echo "<h2>📦 Orders for Customer ID: $customerID</h2>";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Order ID: " . $row["OrderID"] . "<br>";
        echo "Date: " . $row["OrderDate"] . "<br>";
        echo "Status: " . $row["OrderStatus"] . "<br>";
        echo "Total: ₹" . $row["TotalAmount"] . "<hr>";
    }
} else {
    echo "No orders found.";
}
?>
