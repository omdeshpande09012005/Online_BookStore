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
$message = "";

// Fetch current book details
$sql = "SELECT * FROM Books WHERE BookID = $bookID";
$result = $conn->query($sql);
$book = $result->fetch_assoc();

if (!$book) {
    echo "Book not found.";
    exit();
}

// Generate a slug from the book title and assume the image is saved as PNG.
$slug = strtolower(str_replace(' ', '_', trim($book['Title'])));
$localImagePath = "images/{$slug}.png";
// Check with an absolute path if the image exists.
if (file_exists("C:/xampp/htdocs/OnlineBookstore/{$localImagePath}")) {
    $img_src = $localImagePath;
} else {
    $img_src = "images/placeholder.png";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $isbn = $_POST['isbn'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $categoryID = $_POST['category_id'];

    $updateSQL = "UPDATE Books 
                  SET Title=?, Author=?, Publisher=?, ISBN=?, Price=?, Stock=?, CategoryID=? 
                  WHERE BookID=?";
    $stmt = $conn->prepare($updateSQL);
    $stmt->bind_param("ssssdiii", $title, $author, $publisher, $isbn, $price, $stock, $categoryID, $bookID);

    if ($stmt->execute()) {
        $message = "✅ Book updated successfully!";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Book | Admin</title>
    <style>
        /* Global styles */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #2c3e50;
            margin: 0;
            padding: 30px;
            color: #ECF0F1;
        }
        /* Top navigation */
        .topnav {
            margin-bottom: 20px;
        }
        .topnav a {
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
        }
        .topnav a:hover {
            text-decoration: underline;
        }
        /* Container with Glassmorphism-Inspired Dark Card */
        .container {
            max-width: 600px;
            margin: auto;
            background: rgba(52, 73, 94, 0.85);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ECF0F1;
        }
        /* Image styling */
        .book-image {
            text-align: center;
            margin-bottom: 20px;
        }
        .book-image img {
            max-width: 200px;
            border-radius: 8px;
        }
        /* Form Elements */
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        input, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }
        button {
            background: #3498db;
            color: white;
            padding: 12px;
            border: none;
            width: 100%;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #2980b9;
        }
        /* Message styling */
        .msg {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            color: #2ecc71;
        }
    </style>
</head>
<body>
    <div class="topnav">
        <a href="admin_manage_books.php">← Back to Book List</a>
    </div>
    <div class="container">
        <h2>✏️ Edit Book Details</h2>
        <div class="book-image">
            <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($book['Title']); ?>">
        </div>
        <?php if ($message): ?>
            <div class="msg"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post">
            <label>Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($book['Title']); ?>" required>

            <label>Author:</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($book['Author']); ?>" required>

            <label>Publisher:</label>
            <input type="text" name="publisher" value="<?php echo htmlspecialchars($book['Publisher']); ?>">

            <label>ISBN:</label>
            <input type="text" name="isbn" value="<?php echo htmlspecialchars($book['ISBN']); ?>" required>

            <label>Price:</label>
            <input type="number" name="price" step="0.01" value="<?php echo $book['Price']; ?>" required>

            <label>Stock:</label>
            <input type="number" name="stock" value="<?php echo $book['Stock']; ?>" required>

            <label>Category:</label>
            <select name="category_id" required>
                <?php
                $catQuery = "SELECT * FROM Categories";
                $catResult = $conn->query($catQuery);
                while ($cat = $catResult->fetch_assoc()) {
                    $selected = ($book['CategoryID'] == $cat['CategoryID']) ? "selected" : "";
                    echo "<option value='{$cat['CategoryID']}' $selected>{$cat['CategoryName']}</option>";
                }
                ?>
            </select>

            <button type="submit">Update Book</button>
        </form>
    </div>
</body>
</html>
