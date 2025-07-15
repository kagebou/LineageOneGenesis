<?php
// Connection settings
$host = "localhost";
$user = "root";
$pass = "admin";
$db   = "original";

// Connect to MySQL
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get search query
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// ✅ Correct column names based on your table: mobname, itemname, min, max, chance
$sql = "SELECT mobname, itemname, min, max, chance FROM droplist ";
if ($search !== '') {
  $sql .= "WHERE itemname LIKE '%$search%' OR mobname LIKE '%$search%' ";
}
$sql .= "ORDER BY mobname";

$result = $conn->query($sql);

// Output
if ($result && $result->num_rows > 0) {
  echo "<div class='text-white p-4 space-y-2'>";
  while ($row = $result->fetch_assoc()) {
    echo "<div class='bg-white/10 p-2 rounded border border-white/20'>
            <strong>Mob:</strong> {$row['mobname']}<br>
            <strong>Item:</strong> {$row['itemname']}<br>
            <strong>Amount:</strong> {$row['min']} ~ {$row['max']}<br>
            <strong>Chance:</strong> {$row['chance']}%
          </div>";
  }
  echo "</div>";
} else {
  echo "<p class='text-gray-400 italic'>No drops found matching your search.</p>";
}

$conn->close();
?>
