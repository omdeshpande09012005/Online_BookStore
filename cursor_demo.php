<?php
include "includes/config.php";
echo "<h2>📚 All Book Titles (via Cursor Procedure)</h2>";

$result = $conn->query("CALL ListAllBookTitles()");
while ($row = $result->fetch_assoc()) {
    echo "📘 " . $row['Title'] . "<br>";
}
?>
