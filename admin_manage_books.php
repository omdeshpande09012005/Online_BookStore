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
    <title>Manage Books | Admin</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #2c3e50;
            margin: 0;
            padding: 40px;
            color: #ECF0F1;
        }
        /* Main Container */
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        /* Top Navigation */
        .topnav {
            margin-bottom: 30px;
        }
        .topnav a {
            text-decoration: none;
            margin-right: 20px;
            color: #ECF0F1;
            font-size: 16px;
        }
        .topnav a:hover {
            text-decoration: underline;
        }
        /* Page Title */
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #ECF0F1;
            font-size: 28px;
        }
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background: #34495e;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            border-radius: 6px;
            overflow: hidden;
        }
        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #2c3e50;
        }
        th {
            background: #2980b9;
            color: #fff;
            font-weight: 600;
        }
        tr:hover {
            background: #3d566e;
        }
        /* Image Styling */
        td img {
            width: 60px;
            height: auto;
            border-radius: 4px;
        }
        /* Button Styling */
        a.btn {
            padding: 6px 12px;
            background: #27ae60;
            color: #fff;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            transition: background 0.3s ease;
        }
        a.btn:hover {
            background: #1e8449;
        }
        /* Actions Container */
        .actions {
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="topnav">
            <a href="admin_dashboard.php">← Back to Dashboard</a>
        </div>
        <h2>📚 Manage Books</h2>
        <table>
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Author</th>
                <th>Price (₹)</th>
                <th>Stock</th>
                <th>CategoryID</th>
                <th>Actions</th>
            </tr>
            <?php
            $sql = "SELECT * FROM Books ORDER BY BookID DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0):
                while ($row = $result->fetch_assoc()):
                    // Create a slug from the book title for the image name.
                    $slug = strtolower(str_replace(' ', '_', trim($row['Title'])));
                    $localImagePath = "images/{$slug}.png"; // Assuming your images are saved as PNG
                    // Check using an absolute path:
                    if (file_exists("C:/xampp/htdocs/OnlineBookstore/{$localImagePath}")) {
                        $img_src = $localImagePath;
                    } else {
                        $img_src = "images/placeholder.png";
                    }
            ?>
            <tr>
                <td>
                    <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($row['Title']); ?>">
                </td>
                <td><?php echo htmlspecialchars($row['Title']); ?></td>
                <td><?php echo htmlspecialchars($row['Author']); ?></td>
                <td><?php echo number_format($row['Price'], 2); ?></td>
                <td><?php echo $row['Stock']; ?></td>
                <td><?php echo $row['CategoryID']; ?></td>
                <td class="actions">
                    <a class="btn" href="edit_book.php?book_id=<?php echo $row['BookID']; ?>">✏️ Edit</a>
                    <a class="btn" href="delete_book.php?book_id=<?php echo $row['BookID']; ?>" onclick="return confirm('Are you sure you want to delete this book?');">🗑️ Delete</a>
                    <a class="btn" href="view_reviews.php?book_id=<?php echo $row['BookID']; ?>">👁️ View Reviews</a>
                </td>
            </tr>
            <?php endwhile;
            else: ?>
                <tr><td colspan="7" style="text-align: center;">No books found.</td></tr>
            <?php endif; ?>
        </table>
    </div>
</body>
</html>
