<?php
session_start();
include "includes/config.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM Customers WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $_SESSION['customer_id'] = $user['CustomerID'];
            $_SESSION['customer_name'] = $user['FirstName'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with this email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>📚 OnlineBookstore - Login</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Global Styles */
        body {
            margin: 0;
            background-image: url('https://images.unsplash.com/photo-1512820790803-83ca734da794');
            background-size: cover;
            background-position: center;
            font-family: 'Poppins', sans-serif;
            color: #fff;
            position: relative;
            min-height: 100vh;
        }

        /* Dark overlay for better contrast */
        .overlay {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 0;
        }

        /* Branding text at the top */
        .branding {
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            color: #fff;
            margin-top: 60px;
            text-shadow: 2px 2px 4px #000;
            position: relative;
            z-index: 1;
        }

        /* Form container with glassmorphism effect */
        .container {
            position: relative;
            z-index: 1;
            width: 400px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.15);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }

        h2 {
            text-align: center;
            color: #fff;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Label styling (ensuring they’re visible) */
        label {
            font-weight: 600;
            display: block;
            margin-bottom: 6px;
            color: #fff;
        }

        /* Updated Input styling for clarity */
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 16px;
            border: none;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            font-size: 16px;
        }

        input::placeholder {
            color: #666;
        }

        button {
            background-color: #ff6f61;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease-in-out, transform 0.2s;
        }

        button:hover {
            background-color: #e75b52;
            transform: scale(1.02);
        }

        .error {
            color: #ff6f61;
            text-align: center;
            font-weight: bold;
            margin-top: 12px;
        }

        .footer {
            text-align: center;
            color: #ddd;
            font-size: 14px;
            position: fixed;
            bottom: 15px;
            width: 100%;
            z-index: 1;
        }
    </style>
</head>
<body>
    <div class="overlay"></div>

    <div class="branding">📚 Welcome to OnlineBookstore</div>

    <div class="container">
        <h2>Login</h2>

        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label>Email:</label>
            <input type="email" name="email" placeholder="Enter your email" required>

            <label>Password:</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>
    </div>

    <div class="footer">
        Developed by: Om Deshpande, Aayush Das, Parth Patil, Devavrat Joshi
    </div>
</body>
</html>
