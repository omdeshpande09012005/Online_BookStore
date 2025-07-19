<?php
session_start();
include "includes/config.php"; // Ensure the database connection is properly included

if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}

// Debug: Check if database connection is valid
if (!$conn) {
    die("Database connection failed.");
}

$sql = "SELECT * FROM Books";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Books | OnlineBookstore</title>
  <link rel="stylesheet" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    /* Global Reset */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; color: #fff; overflow-x: hidden; }

    /* Animated Gradient Background */
    body::before {
      content: "";
      position: fixed;
      top: 0; left: 0;
      width: 100vw; height: 100vh;
      background: linear-gradient(-45deg, #ff6f61, #3498db, #27ae60, #8e44ad);
      background-size: 400% 400%;
      animation: gradientShift 12s infinite ease-in-out;
      z-index: -1;
    }

    @keyframes gradientShift {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Floating Motion */
    .floating { animation: floatMotion 6s infinite ease-in-out; }
    @keyframes floatMotion {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    /* Navbar */
    header {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      padding: 15px 0;
      position: sticky;
      top: 0;
      width: 100%;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    }
    .navbar {
      max-width: 1200px;
      margin: auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
    }
    .navbar .logo { font-size: 26px; font-weight: 600; color: white; text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4); }
    .navbar nav ul { display: flex; gap: 20px; }
    .navbar nav ul li { list-style: none; }
    .navbar nav ul li a {
      font-size: 16px;
      color: white;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
      transition: color 0.3s ease;
    }
    .navbar nav ul li a:hover { color: #f1c40f; }

    /* Hero Section */
    .hero-section {
      text-align: center;
      padding: 80px 20px;
    }
    .hero-section h1 {
      font-size: 48px;
      text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.4);
      animation: fadeInDown 1.2s ease-in-out;
    }
    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* Books Grid */
    .book-container {
      max-width: 1200px;
      margin: 40px auto;
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }

    /* Book Cards with Neon Glow */
    .book-card {
      background: rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(15px);
      border-radius: 12px;
      box-shadow: 0 6px 25px rgba(255, 255, 255, 0.2);
      overflow: hidden;
      width: 250px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .book-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 35px rgba(255, 255, 255, 0.3);
    }
    .book-card img {
    width: 200px; /* Standard book cover width */
    height: 300px; /* Standard book cover height */
    object-fit: cover; /* Ensures image maintains its aspect ratio */
    border-radius: 8px; /* Slightly rounded corners for aesthetics */
}

    .book-content { padding: 15px; }
    .book-title { font-size: 18px; font-weight: 600; margin-bottom: 8px; }
    .book-author { font-size: 14px; color: #ddd; margin-bottom: 8px; }
    .book-price { font-size: 16px; font-weight: 600; color: #f1c40f; }

    /* Button */
    .btn-add {
      display: block;
      text-align: center;
      padding: 10px;
      background: #f1c40f;
      color: black;
      font-weight: 600;
      border-radius: 8px;
      transition: background 0.3s ease;
    }
    .btn-add:hover { background: #e1b50f; }
  </style>
</head>
<body>

<header>
  <div class="navbar">
    <div class="logo">OnlineBookstore</div>
    <nav>
      <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="cart.php">View Cart</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </div>
</header>

<section class="hero-section floating">
  <h1>📖 Browse Our Books</h1>
  <p>Discover a world of stories and knowledge.</p>
</section>

<div class="book-container">
  <?php
  $sql = "SELECT * FROM Books";
  $result = $conn->query($sql);

  if ($result->num_rows > 0):
    while ($book = $result->fetch_assoc()):
      $slug = strtolower(str_replace(' ', '_', trim($book['Title'])));
      $localImagePath = "images/{$slug}.jpg";
      $img_src = file_exists("C:/xampp/htdocs/OnlineBookstore/{$localImagePath}") ? $localImagePath : "https://source.unsplash.com/250x220/?book," . urlencode($book['Title']);
  ?>
    <div class="book-card floating">
      <img src="<?php echo $img_src; ?>" alt="Book Image">
      <div class="book-content">
        <div class="book-title"><?php echo htmlspecialchars($book['Title']); ?></div>
        <div class="book-author">By <?php echo htmlspecialchars($book['Author']); ?></div>
        <div class="book-price">₹<?php echo number_format($book['Price'], 2); ?></div>
        <a class="btn-add" href="php/add_to_cart.php?book_id=<?php echo $book['BookID']; ?>">Add to Cart</a>
      </div>
    </div>
  <?php endwhile; endif; ?>
</div>

</body>
</html>
