<?php
// ✅ Set UTF-8 header to fix emoji display issue
header('Content-Type: text/html; charset=UTF-8');

// Database connection
$host = "localhost";
$user = "root";
$password = "admin";
$database = "original";

$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$username = $_POST['username'];
$password_raw = $_POST['password'];
$password_hash = sha1($password_raw);

// Check if username exists
$check = $conn->query("SELECT * FROM accounts WHERE login='$username'");

if ($check->num_rows > 0) {
    // Username exists - animated error
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Username Exists</title>
      <script src="https://cdn.tailwindcss.com"></script>
      <style>
        @keyframes waveUpDown {
          0%, 100% { transform: translateY(0); }
          50% { transform: translateY(-10px); }
        }
        .wave-text span {
          display: inline-block;
          animation: waveUpDown 1.5s ease-in-out infinite;
          margin-right: 0.5px;
        }
        .wave-text .space {
          width: 0.6em;
        }
      </style>
    </head>
    <body class="min-h-screen bg-black text-white flex items-center justify-center relative overflow-hidden">
      <!-- 🔴 Live Video Background -->
      <video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
        <source src="Lineage Eternal Kai Animated Wallpaper.mp4" type="video/mp4">
      </video>

      <div class="bg-white/10 border border-red-400 p-6 rounded-lg shadow-lg text-center max-w-md z-10">
        <h2 class="text-2xl font-bold mb-4 text-red-300 wave-text">';

        $message = "🚫 Username already exists!";
        $letters = mb_str_split($message);
        foreach ($letters as $i => $char) {
            if ($char === ' ') {
                echo "<span class='space' style='--i:$i'>&nbsp;</span>";
            } else {
                echo "<span style='--i:$i'>" . htmlspecialchars($char) . "</span>";
            }
        }

    echo '</h2>
        <button onclick="window.location.href=\'index.html\'" class="mt-4 px-6 py-2 bg-purple-600 hover:bg-purple-700 rounded-lg font-semibold transition">Return to Login</button>
      </div>
    </body>
    </html>';
    exit;
}

// Register new account
$sql = "INSERT INTO accounts (login, password, access_level, lastactive) 
        VALUES ('$username', '$password_plain', 0, NOW())";

if ($conn->query($sql) === TRUE) {
    // Success message - animated
    echo '
    <!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Registration Success</title>
      <script src="https://cdn.tailwindcss.com"></script>
      <style>
        @keyframes waveUpDown {
          0%, 100% { transform: translateY(0); }
          50% { transform: translateY(-10px); }
        }
        .wave-text span {
          display: inline-block;
          animation: waveUpDown 1.5s ease-in-out infinite;
          margin-right: 0.5px;
        }
        .wave-text .space {
          width: 0.6em;
        }
      </style>
    </head>
    <body class="min-h-screen bg-black text-white flex items-center justify-center relative overflow-hidden">
      <!-- ✅ Live Video Background -->
      <video autoplay muted loop playsinline class="fixed top-0 left-0 w-full h-full object-cover z-[-1]">
        <source src="Lineage Eternal Kai Animated Wallpaper.mp4" type="video/mp4">
      </video>

      <div class="bg-white/10 border border-green-400 p-6 rounded-lg shadow-lg text-center max-w-md z-10">
        <h2 class="text-2xl font-bold mb-4 text-green-300 wave-text">';

        $message = "✅ Account registered successfully!";
        $letters = mb_str_split($message);
        foreach ($letters as $i => $char) {
            if ($char === ' ') {
                echo "<span class='space' style='--i:$i'>&nbsp;</span>";
            } else {
                echo "<span style='--i:$i'>" . htmlspecialchars($char) . "</span>";
            }
        }

    echo '</h2>
        <button onclick="window.location.href=\'index.html\'" class="mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 rounded-lg font-semibold transition">Proceed to Login</button>
      </div>
    </body>
    </html>';
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
