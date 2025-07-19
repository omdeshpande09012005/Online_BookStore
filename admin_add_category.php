<?php
session_start();
include "includes/config.php";

// Ensure that the user is an admin
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $catName = trim($_POST['category_name']);
    $description = trim($_POST['description']);

    if (!empty($catName)) {
        $sql = "INSERT INTO Categories (CategoryName, Description) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $catName, $description);

        if ($stmt->execute()) {
            $message = "✅ Category added successfully!";
        } else {
            $message = "❌ Error: " . $conn->error;
        }
    } else {
        $message = "⚠️ Category name cannot be empty.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Add Category | Admin</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #2c3e50;
            margin: 0;
            padding: 40px;
            color: #ECF0F1;
        }
        /* Top Navigation */
        .topnav {
            margin-bottom: 20px;
        }
        .topnav a {
            text-decoration: none;
            color: #3498db;
            font-size: 16px;
            margin-right: 15px;
        }
        .topnav a:hover {
            text-decoration: underline;
        }
        /* Main Container */
        .container {
            max-width: 500px;
            margin: auto;
            background: rgba(52, 73, 94, 0.85);
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.4);
        }
        /* Heading */
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #ECF0F1;
        }
        /* Form Elements */
        label {
            font-weight: bold;
            color: #ECF0F1;
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background: rgba(236, 240, 241, 0.2);
            color: #ECF0F1;
        }
        input[type="text"]::placeholder, textarea::placeholder {
            color: #BDC3C7;
        }
        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            color: #fff;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #2980b9;
        }
        /* Message Styling */
        .msg {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #27ae60;
        }
        .error {
            color: #e74c3c;
        }
    </style>
</head>
<body>

<div class="topnav">
    <a href="admin_dashboard.php">← Back to Dashboard</a>
</div>

<div class="container">
    <h2>➕ Add New Category</h2>
    <?php if ($message): ?>
        <div class="msg"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Category Name:</label>
        <input type="text" name="category_name" placeholder="Enter category name" required>

        <label>Description:</label>
        <textarea name="description" rows="4" placeholder="Enter description"></textarea>

        <button type="submit">Add Category</button>
    </form>
</div>

</body>
</html>
