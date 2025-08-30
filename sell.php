<?php
require_once "session.php";
require_once "config/db.php";

// Ambil data barang
$items = $conn->query("SELECT * FROM items");

if (isset($_POST['submit'])) {
    $item_id = $_POST['item_id'];
    $qty = (int) $_POST['quantity'];

    // Ambil detail barang
    $item = $conn->query("SELECT * FROM items WHERE id=$item_id")->fetch_assoc();

    // Cek stok cukup
    if ($item['stock'] < $qty) {
        header("Location: sell.php?error=stok_kurang");
        exit();
    }

    $harga = $item['purchase_price'];
    $untung = $item['profit'];
    $total_uang_masuk = ($harga + $untung) * $qty;
    $total_profit = $untung * $qty;

    // Kurangi stok
    $conn->query("UPDATE items SET stock = stock - $qty WHERE id=$item_id");

    // Tambah saldo & keuntungan
    $conn->query("UPDATE settings SET saldo = saldo + $total_uang_masuk, total_profit = total_profit + $total_profit WHERE id=1");

    // Simpan riwayat
    $conn->query("INSERT INTO sales (item_id, quantity) VALUES ($item_id, $qty)");

    header("Location: sell.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Penjualan Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6 bg-gray-100">
    <a href="dashboard.php" class="p-4 bg-white rounded shadow hover:bg-blue-50">
        🏠 <strong>Dashboard</strong>
    </a>
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Penjualan Barang</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 mb-3 rounded">Barang berhasil dijual.</div>
        <?php elseif (isset($_GET['error']) && $_GET['error'] === 'stok_kurang'): ?>
            <div class="bg-red-100 text-red-700 px-4 py-2 mb-3 rounded">Stok tidak cukup untuk dijual.</div>
        <?php endif; ?>

        <form method="POST">
            <label class="block mb-2">Pilih Barang:</label>
            <select name="item_id" required class="w-full mb-3 p-2 border rounded">
                <?php while ($item = $items->fetch_assoc()): ?>
                    <option value="<?= $item['id'] ?>">
                        <?= $item['name'] ?> - Stok: <?= $item['stock'] ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <input type="number" name="quantity" placeholder="Jumlah jual" required
                class="w-full mb-3 p-2 border rounded" />

            <button name="submit" class="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600">Jual</button>
        </form>
    </div>
</body>

</html>