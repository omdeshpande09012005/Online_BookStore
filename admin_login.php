<?php
session_start();
include "includes/config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Admin WHERE Username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        if (password_verify($password, $admin['Password'])) {
            $_SESSION['admin_id'] = $admin['AdminID'];
            $_SESSION['admin_user'] = $admin['Username'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Admin not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login | OnlineBookstore</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Importing Poppins for a crisp, modern font style -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600" rel="stylesheet">
    <style>
        /* Overall Page Layout */
        body {
            margin: 0;
            padding: 0;
            background: #2c3e50;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        /* Login Container with Clear and Minimal Styling */
        .login-container {
            width: 360px;
            background: #34495e;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
            color: #ecdbba;
        }
        /* Labels & Inputs */
        form label {
            font-size: 14px;
            margin-bottom: 5px;
            color: #ecf0f1;
            display: block;
        }
        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 4px;
            background: #ecf0f1;
            font-size: 14px;
            /* Set input text color to dark for legibility */
            color: #2c3e50;
        }
        /* Placeholder text styling */
        form input::placeholder {
            color: #7f8c8d;
        }
        /* Submit Button */
        form button {
            width: 100%;
            padding: 10px;
            background: #27ae60;
            border: none;
            color: #fff;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        form button:hover {
            background: #219150;
        }
        /* Error Message Styling */
        .error {
            color: #e74c3c;
            text-align: center;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Username:</label>
            <input type="text" name="username" placeholder="Enter your username" required>
            
            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>
            
            <button type="submit">Login as Admin</button>
        </form>
    </div>
</body>
</html>
