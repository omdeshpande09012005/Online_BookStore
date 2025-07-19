<form method="post">
    <input type="text" name="password" placeholder="Enter password to hash">
    <button type="submit">Generate Hash</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "<strong>Hashed Password:</strong><br>";
    echo password_hash($_POST['password'], PASSWORD_DEFAULT);
}
