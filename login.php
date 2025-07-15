<?php
// Start session to keep user login state
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "admin";
$db   = "original";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// If form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password_raw = $_POST['password'] ?? '';

  if ($username === '' || $password_raw === '') {
    $error = "Please enter both username and password.";
  } else {
    // Hash the password (using sha1 as your system uses)
    $password_hash = sha1($password_raw);

    // Prepare and execute query to prevent SQL injection
    $stmt = $conn->prepare("SELECT login, access_level FROM accounts WHERE login = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
      // User found - set session
      $user = $result->fetch_assoc();
      $_SESSION['username'] = $user['login'];
      $_SESSION['access_level'] = $user['access_level'];

      // Redirect to protected page (change as needed)
      header("Location: dashboard.php");
      exit;
    } else {
      $error = "Invalid username or password.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Login - Lineage 1</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-black flex items-center justify-center text-white">
  <div class="bg-white/10 p-8 rounded-lg max-w-md w-full shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-center">Lineage 1 Login</h1>

    <?php if (!empty($error)): ?>
      <div class="bg-red-600 text-white p-3 rounded mb-4 text-center font-semibold">
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="login.php" class="space-y-6">
      <div>
        <label for="username" class="block mb-2 font-semibold">Username</label>
        <input id="username" name="username" type="text" required
          class="w-full px-4 py-2 rounded bg-black text-white border border-gray-600 focus:outline-none focus:border-purple-500" />
      </div>

      <div>
        <label for="password" class="block mb-2 font-semibold">Password</label>
        <input id="password" name="password" type="password" required
          class="w-full px-4 py-2 rounded bg-black text-white border border-gray-600 focus:outline-none focus:border-purple-500" />
      </div>

      <button type="submit"
        class="w-full py-3 bg-purple-600 hover:bg-purple-700 rounded font-bold transition">Login</button>
    </form>
  </div>
</body>
</html>
