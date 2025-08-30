<?php
require_once "session.php";
require_once "config/db.php";

$setting = $conn->query("SELECT saldo, total_profit FROM settings WHERE id=1")->fetch_assoc();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6 bg-gray-100">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Dashboard</h1>
        <a href="auth/logout.php" class="text-red-500 hover:underline">Logout</a>
    </div>

    <p class="text-gray-700 mb-6">Halo, <strong><?= $_SESSION['user'] ?></strong> 👋</p>

    <div class="p-4 bg-white rounded shadow mb-6 flex justify-between items-center">
        <div>
            <p class="text-lg">💰 <strong>Saldo saat ini:</strong> Rp<?= number_format($setting['saldo']) ?></p>
            <p class="text-lg mt-2">📈 <strong>Total Keuntungan:</strong>
                Rp<?= number_format($setting['total_profit']) ?></p>
        </div>
        <div class="flex justify-between w-72">
            <a href="balance-topup.php" class="p-4 bg-white rounded shadow hover:bg-blue-100">
                📥 <strong>Top Up</strong>
            </a>
            <a href="balance-withdraw.php" class="p-4 bg-white rounded shadow hover:bg-red-100">
                📤 <strong>Withdraw</strong>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <a href="items/list.php" class="p-4 bg-white rounded shadow hover:bg-blue-100">
            📦 <strong>Kelola Barang</strong>
            <p class="text-sm text-gray-500 mt-1">Tambah, edit, dan lihat daftar barang</p>
        </a>

        <a href="balance_logs.php" class="p-4 bg-white rounded shadow hover:bg-green-100">
            📄 <strong>Riwayat Saldo</strong>
            <p class="text-sm text-gray-500 mt-1">Lihat histori saldo</p>
        </a>

        <a href="purchase.php" class="p-4 bg-white rounded shadow hover:bg-green-100">
            🛒 <strong>Pembelian Barang</strong>
            <p class="text-sm text-gray-500 mt-1">Beli barang dan tambah stok</p>
        </a>

        <a href="sell.php" class="p-4 bg-white rounded shadow hover:bg-yellow-100">
            💸 <strong>Penjualan Barang</strong>
            <p class="text-sm text-gray-500 mt-1">Jual barang dan dapatkan untung</p>
        </a>

        <a href="purchase-history.php" class="p-4 bg-white rounded shadow hover:bg-purple-100">
            📜 <strong>Riwayat Pembelian</strong>
            <p class="text-sm text-gray-500 mt-1">Lihat histori pembelian</p>
        </a>

        <a href="sales-history.php" class="p-4 bg-white rounded shadow hover:bg-pink-100">
            📈 <strong>Riwayat Penjualan</strong>
            <p class="text-sm text-gray-500 mt-1">Lihat histori penjualan</p>
        </a>
    </div>
</body>


</html>