<?php
session_start();
require_once "../config/db.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $_SESSION['user'] = $username;
        header("Location: ../dashboard.php");
        exit();
    } else {
        $error = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">
    <form method="POST" class="bg-white p-6 rounded shadow-md w-80">
        <h2 class="text-xl font-semibold mb-4 text-center">Login</h2>

        <?php if (isset($error)): ?>
            <div class="text-red-500 text-sm mb-2"><?= $error ?></div>
        <?php endif; ?>

        <input type="text" name="username" placeholder="Username" required class="w-full mb-3 p-2 border rounded" />
        <input type="password" name="password" placeholder="Password" required class="w-full mb-3 p-2 border rounded" />
        <button type="submit" name="login" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">
            Login
        </button>
    </form>
</body>

</html>