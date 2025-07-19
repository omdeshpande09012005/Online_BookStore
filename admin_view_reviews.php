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
    <title>Admin - Book Reviews</title>
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
            margin-right: 15px;
        }

        .review-block {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 20px;
            margin-bottom: 25px;
        }

        .book-title {
            font-size: 20px;
            color: #34495e;
            font-weight: bold;
            margin-bottom: 10px;
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
    <a href="admin_dashboard.php">← Back to Dashboard</a>
</div>

<h2>📖 Book Reviews by Customers</h2>

<?php
$sql = "SELECT r.*, c.FirstName, c.LastName, b.Title
        FROM Reviews r
        JOIN Customers c ON r.CustomerID = c.CustomerID
        JOIN Books b ON r.BookID = b.BookID
        ORDER BY r.ReviewDate DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0):
    $currentBook = "";
    while ($row = $result->fetch_assoc()):
        if ($currentBook !== $row['Title']):
            if ($currentBook !== "") echo "</div>"; // Close previous block
            $currentBook = $row['Title'];
?>
    <div class="review-block">
        <div class="book-title">📘 <?php echo htmlspecialchars($currentBook); ?></div>
<?php
        endif;
?>
        <div class="review">
            <span class="rating">Rating: <?php echo $row['Rating']; ?>/5 ⭐</span><br>
            <span class="customer-name">by <?php echo $row['FirstName'] . ' ' . $row['LastName']; ?></span><br>
            <p><?php echo htmlspecialchars($row['ReviewText']); ?></p>
            <span class="date"><?php echo $row['ReviewDate']; ?></span>
        </div>
<?php
    endwhile;
    echo "</div>"; // Close last block
else:
    echo "<p>No reviews found.</p>";
endif;
?>

</body>
</html>
