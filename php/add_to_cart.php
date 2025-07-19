<?php
session_start();
include "../includes/config.php";

// If book_id is not passed, redirect back
if (!isset($_GET['book_id'])) {
    header("Location: ../books.php");
    exit();
}

$bookID = $_GET['book_id'];

// Fetch book details
$sql = "SELECT * FROM Books WHERE BookID = $bookID";
$result = $conn->query($sql);

if ($result->num_rows === 1) {
    $book = $result->fetch_assoc();

    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // If book already in cart, increase quantity
    if (isset($_SESSION['cart'][$bookID])) {
        $_SESSION['cart'][$bookID]['quantity'] += 1;
    } else {
        // Add book to cart
        $_SESSION['cart'][$bookID] = [
            'title' => $book['Title'],
            'price' => $book['Price'],
            'quantity' => 1
        ];
    }
}

header("Location: ../cart.php"); // Redirect to cart after adding
exit();
