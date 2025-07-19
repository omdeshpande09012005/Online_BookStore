<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}
$adminUser = $_SESSION['admin_user'];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | OnlineBookstore</title>
    <style>
        /* Global Styles */
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: #1f1f1f;
            color: #ECECEC;
        }
        /* Hero Section */
        .hero {
            background: linear-gradient(90deg, #34495e, #2c3e50);
            padding: 50px 20px;
            text-align: center;
        }
        .hero h1 {
            margin: 0;
            font-size: 32px;
            color: #ECF0F1;
        }
        .hero p {
            color: #BDC3C7;
            font-size: 16px;
        }
        /* Cards Container */
        .cards {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            padding: 40px 20px;
        }
        /* Individual Card Styling */
        .card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            width: 260px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.6);
        }
        .card img {
            width: 70px;
            margin-bottom: 15px;
        }
        .card h3 {
            font-size: 18px;
            color: #ECF0F1;
            margin-bottom: 10px;
        }
        .card a {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #3498db;
            color: #fff;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }
        .card a:hover {
            background: #2980b9;
        }
        /* Footer */
        .footer {
            text-align: center;
            font-size: 14px;
            padding: 20px;
            background: #2c3e50;
            color: #BDC3C7;
        }
    </style>
</head>
<body>
    <div class="hero">
        <h1>Welcome, Admin <?php echo htmlspecialchars($adminUser); ?> 👑</h1>
        <p>Manage your OnlineBookstore dashboard with precision</p>
    </div>
    <div class="cards">
        <div class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/1055/1055646.png" alt="Books">
            <h3>Manage Books</h3>
            <a href="admin_manage_books.php">📚 Go</a>
        </div>
        <div class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/942/942748.png" alt="Orders">
            <h3>View Orders</h3>
            <a href="admin_view_orders.php">📦 View</a>
        </div>
        <div class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/659/659918.png" alt="Category">
            <h3>Add Category</h3>
            <a href="admin_add_category.php">➕ Add</a>
        </div>
        <div class="card">
            <img src="https://cdn-icons-png.flaticon.com/512/660/660252.png" alt="Logout">
            <h3>Logout</h3>
            <a href="admin_logout.php">🚪 Logout</a>
        </div>
    </div>
    <div class="footer">
        Developed by: Om Deshpande, Aayush Das, Parth Patil, Devavrat Joshi | &copy; 2025 OnlineBookstore
    </div>
</body>
</html>
