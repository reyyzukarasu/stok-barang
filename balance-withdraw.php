<?php
require_once "session.php";
require_once "config/db.php";

// Ambil saldo sekarang
$saldo = $conn->query("SELECT saldo FROM settings WHERE id=1")->fetch_assoc()['saldo'];

if (isset($_POST['withdraw'])) {
    $amount = (int) $_POST['amount'];
    $method = $_POST['method'];
    $proof = $_FILES['proof']['name'];

    if ($amount <= $saldo) {
        if ($proof) {
            $path = "uploads/" . time() . "_" . basename($proof);
            move_uploaded_file($_FILES['proof']['tmp_name'], $path);
        } else {
            $path = null;
        }

        $conn->query("UPDATE settings SET saldo = saldo - $amount WHERE id=1");
        $conn->query("INSERT INTO balance_logs (type, method, amount, proof) VALUES ('withdraw', '$method', $amount, '$path')");
        header("Location: balance-withdraw.php?withdraw=success");
        exit();
    } else {
        header("Location: balance-withdraw.php?error=saldo_kurang");
        exit();
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Saldo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <a href="dashboard.php" class="p-4 bg-white rounded shadow hover:bg-blue-50 mb-4 inline-block">🏠 Dashboard</a>

    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow space-y-6">
        <h2 class="text-xl font-bold text-center">Saldo Saat Ini: <span
                class="text-green-600">Rp<?= number_format($saldo) ?></span></h2>

        <?php if (isset($_GET['withdraw'])): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 rounded">Penarikan berhasil!</div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] == 'saldo_kurang'): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded">Saldo tidak mencukupi!</div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data" class="space-y-3">
            <h3 class="font-semibold">Tarik Saldo</h3>
            <input type="number" name="amount" placeholder="Jumlah tarik" required class="w-full p-2 border rounded">

            <select name="method" required class="w-full p-2 border rounded">
                <option value="tunai">Tunai</option>
                <option value="transfer">Transfer</option>
            </select>

            <input type="file" name="proof" accept="image/*" required class="w-full p-2 border rounded">
            <button name="withdraw" class="w-full bg-red-500 text-white p-2 rounded hover:bg-red-600">Tarik</button>
        </form>

</body>

</html>