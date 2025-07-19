<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (isset($_GET['book_id'])) {
    $bookID = intval($_GET['book_id']);

    // Delete from Books table
    $deleteSQL = "DELETE FROM Books WHERE BookID = ?";
    $stmt = $conn->prepare($deleteSQL);
    $stmt->bind_param("i", $bookID);

    if ($stmt->execute()) {
        header("Location: admin_manage_books.php?msg=deleted");
        exit();
    } else {
        echo "❌ Error deleting book: " . $conn->error;
    }
} else {
    echo "⚠️ No book selected to delete.";
}
?>
