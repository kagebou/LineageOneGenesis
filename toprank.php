<?php
$host = 'localhost';
$dbname = 'original';  // palitan kung iba database name mo
$user = 'root';     // default user, palitan kung iba
$pass = 'admin';         // password, depende sa setup mo

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

$stmt = $pdo->query("SELECT char_name, level FROM characters ORDER BY level DESC, exp DESC LIMIT 10");
$rank = 1;

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<li class='hover:text-yellow-400'>{$rank}. {$row['char_name']} - Level {$row['level']}</li>";
    $rank++;
}
?>
