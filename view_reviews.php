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

// Get book details (only Title since there's no Image column)
$book = $conn->query("SELECT Title FROM Books WHERE BookID = $bookID")->fetch_assoc();
if (!$book) {
    echo "Book not found.";
    exit();
}

// Generate a slug from the book title and assume the image is saved as PNG
$slug = strtolower(str_replace(' ', '_', trim($book['Title'])));
$localImagePath = "images/{$slug}.png";
// Check if the image file exists using its absolute path
if (file_exists("C:/xampp/htdocs/OnlineBookstore/{$localImagePath}")) {
    $img_src = $localImagePath;
} else {
    $img_src = "images/placeholder.png";
}

// Get reviews for this book
$sql = "
    SELECT r.Rating, r.ReviewText, r.ReviewDate, c.FirstName, c.LastName
    FROM Reviews r
    JOIN Customers c ON r.CustomerID = c.CustomerID
    WHERE r.BookID = $bookID
    ORDER BY r.ReviewDate DESC
";
$reviews = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reviews - <?php echo htmlspecialchars($book['Title']); ?></title>
    <style>
        /* Global Settings */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #2c3e50;
            margin: 0;
            padding: 30px;
            color: #ECF0F1;
        }
        /* Container with Glassmorphism-Inspired Dark Card */
        .container {
            max-width: 800px;
            margin: auto;
            background: #34495e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        /* Book Information */
        .book-info {
            text-align: center;
            margin-bottom: 20px;
        }
        .book-info img {
            max-width: 150px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        /* Header & Back Link */
        h2 {
            color: #ECF0F1;
            text-align: center;
            margin-bottom: 20px;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #3498db;
            text-decoration: none;
            font-size: 16px;
        }
        .back-link:hover {
            text-decoration: underline;
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
            padding: 14px 16px;
            border-bottom: 1px solid #2c3e50;
            text-align: left;
        }
        th {
            background: #2980b9;
            color: #fff;
            font-weight: 600;
        }
        tr:hover {
            background: #4e6a85;
        }
    </style>
</head>
<body>
    <div class="container">
        <a class="back-link" href="admin_manage_books.php">← Back to Books</a>
        <div class="book-info">
            <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($book['Title']); ?>">
        </div>
        <h2>📖 Reviews for: "<?php echo htmlspecialchars($book['Title']); ?>"</h2>
        <?php if ($reviews->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Customer</th>
                    <th>Rating ⭐</th>
                    <th>Review</th>
                    <th>Date</th>
                </tr>
                <?php while ($r = $reviews->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($r['FirstName'] . ' ' . $r['LastName']); ?></td>
                    <td><?php echo $r['Rating']; ?></td>
                    <td><?php echo htmlspecialchars($r['ReviewText']); ?></td>
                    <td><?php echo $r['ReviewDate']; ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p style="text-align: center;">No reviews found for this book yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
