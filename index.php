<?php
session_start();
include "includes/config.php";
if (!isset($_SESSION['customer_id'])) {
    header("Location: login.php");
    exit();
}
$customerName = $_SESSION['customer_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard | OnlineBookstore</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
  <style>
    /* Global Reset and Base Styles */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Poppins', sans-serif;
      overflow-x: hidden;
      color: #fff;      
    }
    a { text-decoration: none; }
    
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
    
    /* Navbar with Glassmorphism */
    header {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(12px);
      padding: 15px 0;
      position: sticky;
      top: 0;
      width: 100%;
      z-index: 100;
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
    .navbar .logo {
      font-size: 26px;
      font-weight: 600;
      color: white;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
    }
    .navbar nav ul {
      display: flex;
      gap: 20px;
    }
    .navbar nav ul li a {
      font-size: 16px;
      color: white;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.4);
      transition: color 0.3s ease;
    }
    .navbar nav ul li a:hover {
      color: #f1c40f;
    }
    
    /* Hero Section */
    .hero-section {
      text-align: center;
      padding: 100px 20px;
    }
    .hero-section h1 {
      font-size: 48px;
      margin-bottom: 20px;
      text-shadow: 3px 3px 10px rgba(0,0,0,0.4);
      animation: fadeInDown 1.2s ease-in-out;
    }
    @keyframes fadeInDown {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .hero-section p {
      font-size: 22px;
      margin-bottom: 30px;
      animation: fadeInUp 1.2s ease-in-out;
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background: #f1c40f;
      color: black;
      font-weight: 600;
      border-radius: 8px;
      transition: background 0.3s ease;
    }
    .btn:hover { background: #e1b50f; }
    
    /* Dashboard Cards */
    .cards {
      max-width: 1200px;
      margin: 40px auto;
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }
    .card {
      background: rgba(255,255,255,0.2);
      backdrop-filter: blur(15px);
      border-radius: 12px;
      width: 250px;
      padding: 20px;
      box-shadow: 0 6px 25px rgba(255,255,255,0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 35px rgba(255,255,255,0.3);
    }
    .card h3 {
      font-size: 20px;
      margin-bottom: 10px;
      color: #fff;
    }
    .card p {
      font-size: 16px;
      color: #ddd;
      margin-bottom: 10px;
    }
    
    /* Floating Animation */
    .floating {
      animation: floatMotion 6s infinite ease-in-out;
    }
    @keyframes floatMotion {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
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
        <li><a href="books.php">Browse Books</a></li>
        <li><a href="cart.php">My Cart</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </div>
</header>

<section class="hero-section floating">
  <h1>Welcome, <?php echo htmlspecialchars($customerName); ?>!</h1>
  <p>Discover your next favorite book and explore a world of captivating stories.</p>
  <a class="btn" href="books.php">Browse Books</a>
</section>

<section class="cards">
  <div class="card floating">
    <h3>Featured Books</h3>
    <p>Check out our top picks and trending titles.</p>
    <a class="btn" href="books.php">View Featured</a>
  </div>
  <div class="card floating">
    <h3>My Cart</h3>
    <p>Review the books in your cart and manage your orders.</p>
    <a class="btn" href="cart.php">View Cart</a>
  </div>
  <div class="card floating">
    <h3>My Orders</h3>
    <p>Keep track of your past purchases and order history.</p>
    <a class="btn" href="orders.php">View Orders</a>
  </div>
  <div class="card floating">
    <h3>Logout</h3>
    <p>Securely sign out of your account.</p>
    <a class="btn" href="logout.php">Logout</a>
  </div>
</section>

</body>
</html>
