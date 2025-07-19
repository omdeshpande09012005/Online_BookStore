<?php
session_start();
include "includes/config.php";

if (!isset($_SESSION['customer_id'])) {
    header("Location: index.php");
    exit();
}

$customerID = $_SESSION['customer_id'];
$message = "";

// Ensure book_id is passed through URL
if (!isset($_GET['book_id'])) {
    echo "<p style='color:red; font-size:18px;'>❌ No book selected to review.</p>";
    exit();
}

$bookID = intval($_GET['book_id']);

// Validate that customer has purchased this book
$checkPurchase = $conn->query("
    SELECT b.Title
    FROM Books b
    JOIN OrderDetails od ON b.BookID = od.BookID
    JOIN Orders o ON od.OrderID = o.OrderID
    WHERE o.CustomerID = $customerID AND b.BookID = $bookID
");

if ($checkPurchase->num_rows == 0) {
    echo "<p style='color:red; font-size:18px;'>⚠️ You haven't purchased this book.</p>";
    exit();
}

$book = $checkPurchase->fetch_assoc();

// Generate the book image source using slug method
$slug = strtolower(str_replace(' ', '_', trim($book['Title'])));
$localImagePath = "images/{$slug}.png";
if (file_exists("C:/xampp/htdocs/OnlineBookstore/" . $localImagePath)) {
    $img_src = $localImagePath;
} else {
    $img_src = "images/placeholder.png";
}

// Check if the customer has already reviewed this book
$existingReview = null;
$reviewQuery = $conn->query("SELECT * FROM Reviews WHERE CustomerID = $customerID AND BookID = $bookID");
if ($reviewQuery->num_rows > 0) {
    $existingReview = $reviewQuery->fetch_assoc();
}

// Handle review submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Re-check in case the review was already submitted
    $reviewQuery = $conn->query("SELECT * FROM Reviews WHERE CustomerID = $customerID AND BookID = $bookID");
    if ($reviewQuery->num_rows > 0) {
        $existingReview = $reviewQuery->fetch_assoc();
        $message = "⚠️ You've already reviewed this book.";
    } else {
        $rating = $_POST['rating'];
        $reviewText = $_POST['review_text'];
        $stmt = $conn->prepare("INSERT INTO Reviews (CustomerID, BookID, Rating, ReviewText, ReviewDate) VALUES (?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiis", $customerID, $bookID, $rating, $reviewText);
        if ($stmt->execute()) {
            $message = "✅ Review received successfully!";
            // Retrieve the newly inserted review
            $reviewQuery = $conn->query("SELECT * FROM Reviews WHERE CustomerID = $customerID AND BookID = $bookID");
            if ($reviewQuery->num_rows > 0) {
                $existingReview = $reviewQuery->fetch_assoc();
            }
        } else {
            $message = "❌ Failed to submit review: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review "<?php echo htmlspecialchars($book['Title']); ?>" | OnlineBookstore</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Global Reset */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Poppins', sans-serif;
            color: #fff;
            overflow-x: hidden;
            /* Animated Gradient Background */
            background: linear-gradient(-45deg, #ff6f61, #3498db, #27ae60, #8e44ad);
            background-size: 400% 400%;
            animation: gradientShift 12s infinite ease-in-out;
        }
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        /* Navbar with Glassmorphism */
        header {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(12px);
            padding: 15px 0;
            position: sticky;
            top: 0;
            width: 100%;
            z-index: 100;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        .navbar {
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }
        .navbar .logo {
            font-size: 26px;
            font-weight: 600;
            color: white;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.4);
        }
        .navbar nav ul {
            display: flex;
            gap: 20px;
        }
        .navbar nav ul li a {
            font-size: 16px;
            color: white;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.4);
            transition: color 0.3s ease;
        }
        .navbar nav ul li a:hover {
            color: #f1c40f;
        }
        /* Review Form Container */
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(15px);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(255,255,255,0.2);
            text-align: center;
        }
        h2 {
            font-size: 32px;
            margin-bottom: 20px;
            text-shadow: 2px 2px 6px rgba(0,0,0,0.4);
        }
        .msg {
            color: #27ae60;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-top: 10px;
            text-align: left;
        }
        input,
        textarea {
            width: 100%;
            padding: 12px;
            margin-top: 6px;
            border-radius: 8px;
            border: 1px solid #ccc;
            background: rgba(255,255,255,0.8);
        }
        button {
            background: #3498db;
            color: white;
            padding: 14px;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            margin-top: 20px;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #2980b9;
        }
        /* Review Display Block */
        .review-block {
            margin-top: 40px;
            background: rgba(255,255,255,0.2);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            text-align: left;
        }
        .review-block img {
            max-width: 150px;
            display: block;
            margin-bottom: 15px;
            border-radius: 8px;
        }
        .review-details {
            font-size: 16px;
        }
        .review-details span {
            display: block;
            margin-bottom: 8px;
        }
    </style>
</head>
<body>

<header>
    <div class="navbar">
        <div class="logo">OnlineBookstore</div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="orders.php">My Orders</a></li>
                <li><a href="books.php">Browse Books</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </div>
</header>

<div class="container">
    <h2>📝 Review: "<?php echo htmlspecialchars($book['Title']); ?>"</h2>

    <?php if ($message): ?>
        <div class="msg"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Rating (1 to 5):</label>
        <input type="number" name="rating" min="1" max="5" required>

        <label>Your Review:</label>
        <textarea name="review_text" rows="5" placeholder="Write your feedback..." required></textarea>

        <button type="submit">Submit Review</button>
    </form>

    <?php if ($existingReview): ?>
        <div class="review-block">
            <img src="<?php echo $img_src; ?>" alt="<?php echo htmlspecialchars($book['Title']); ?>">
            <div class="review-details">
                <span><strong>Rating:</strong> <?php echo $existingReview['Rating']; ?> / 5</span>
                <span><strong>Your Review:</strong> <?php echo htmlspecialchars($existingReview['ReviewText']); ?></span>
                <span><strong>Reviewed on:</strong> <?php echo $existingReview['ReviewDate']; ?></span>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
