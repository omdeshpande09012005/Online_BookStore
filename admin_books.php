<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - All Books</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
            background: #f2f2f2;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
        }

        .topnav {
            margin-bottom: 20px;
        }

        .topnav a {
            text-decoration: none;
            color: #3498db;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 14px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #34495e;
            color: white;
        }

        a.btn {
            padding: 6px 12px;
            background: #3498db;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        a.btn:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>

<div class="topnav">
    <a href="admin_dashboard.php">← Back to Dashboard</a>
</div>

<h2>📚 All Books</h2>

<table>
    <tr>
        <th>Book Title</th>
        <th>Author</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Reviews</th>
    </tr>

    <?php
    $sql = "SELECT * FROM Books ORDER BY BookID DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0):
        while ($book = $result->fetch_assoc()):
    ?>
    <tr>
        <td><?php echo htmlspecialchars($book['Title']); ?></td>
        <td><?php echo htmlspecialchars($book['Author']); ?></td>
        <td>₹<?php echo number_format($book['Price'], 2); ?></td>
        <td><?php echo $book['Stock']; ?></td>
        <td>
            <a class="btn" href="admin_book_reviews.php?book_id=<?php echo $book['BookID']; ?>">View Reviews</a>
        </td>
    </tr>
    <?php endwhile; else: ?>
        <tr><td colspan="5">No books available.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
