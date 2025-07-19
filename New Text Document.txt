<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookID = $_POST['book_id'] ?? null;

    if ($bookID !== null && isset($_SESSION['cart'][$bookID])) {
        unset($_SESSION['cart'][$bookID]);
    }
}

header("Location: cart.php");
exit();
?>
