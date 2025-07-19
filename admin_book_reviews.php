<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['book_id'])) {
    echo "No book selected.";
    exit();
}

$bookID = intval($_GET['book_id']);

// Get book title
$bookQuery = "SELECT Title FROM Books WHERE BookID = $bookID";
$bookResult = $conn->query($bookQuery);
$bookTitle = ($bookResult->num_rows > 0) ? $bookResult->fetch_assoc()['Title'] : "Unknown Book";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reviews for <?php echo htmlspecialchars($bookTitle); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            padding: 30px;
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
            color: #2980b9;
        }

        .review-block {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 25px;
        }

        .review {
            border-top: 1px solid #eee;
            padding-top: 10px;
            margin-top: 10px;
        }

        .rating {
            color: #f39c12;
            font-weight: bold;
        }

        .customer-name {
            color: #2c3e50;
            font-style: italic;
        }

        .date {
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="topnav">
    <a href="admin_books.php">← Back to Book List</a>
</div>

<h2>⭐ Reviews for "<?php echo htmlspecialchars($bookTitle); ?>"</h2>

<?php
// Show only reviews from customers who purchased the book
$sql = "
SELECT r.*, c.FirstName, c.LastName
FROM Reviews r
JOIN Customers c ON r.CustomerID = c.CustomerID
WHERE r.BookID = $bookID AND r.CustomerID IN (
    SELECT o.CustomerID
    FROM Orders o
    JOIN OrderDetails od ON o.OrderID = od.OrderID
    WHERE od.BookID = $bookID
)
ORDER BY r.ReviewDate DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0):
    while ($row = $result->fetch_assoc()):
?>
    <div class="review-block">
        <div class="review">
            <span class="rating">Rating: <?php echo $row['Rating']; ?>/5 ⭐</span><br>
            <span class="customer-name">by <?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></span><br>
            <p><?php echo htmlspecialchars($row['ReviewText']); ?></p>
            <span class="date"><?php echo $row['ReviewDate']; ?></span>
        </div>
    </div>
<?php
    endwhile;
else:
    echo "<p>No verified reviews for this book yet.</p>";
endif;
?>

</body>
</html>
