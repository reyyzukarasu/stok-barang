<?php
require_once "session.php";
require_once "config/db.php";

// Ambil data barang
$items = $conn->query("SELECT * FROM items");

// Handle form
if (isset($_POST['submit'])) {
    $item_id = $_POST['item_id'];
    $qty = (int) $_POST['quantity'];
    $shipping_cost = (int) $_POST['shipping_cost'];

    // Ambil data item
    $item = $conn->query("SELECT * FROM items WHERE id=$item_id")->fetch_assoc();
    $total_price = ($item['purchase_price'] * $qty) + $shipping_cost;

    // Update stok barang
    $conn->query("UPDATE items SET stock = stock + $qty WHERE id=$item_id");

    // Kurangi saldo
    $conn->query("UPDATE settings SET saldo = saldo - $total_price WHERE id=1");

    // Simpan ke riwayat pembelian, termasuk ongkir
    $conn->query("INSERT INTO purchases (item_id, quantity, shipping_cost) VALUES ($item_id, $qty, $shipping_cost)");

    header("Location: purchase.php?success=1");
    exit();
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Beli Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6 bg-gray-100">
    <a href="dashboard.php" class="p-4 bg-white rounded shadow hover:bg-blue-50">
        🏠 <strong>Dashboard</strong>
    </a>
    <div class="max-w-md mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Pembelian Barang</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="bg-green-100 text-green-700 px-4 py-2 mb-3 rounded">Berhasil membeli barang.</div>
        <?php endif; ?>

        <form method="POST">
            <label class="block mb-2">Pilih Barang:</label>
            <select name="item_id" required class="w-full mb-3 p-2 border rounded">
                <?php while ($item = $items->fetch_assoc()): ?>
                    <option value="<?= $item['id'] ?>"><?= $item['name'] ?> - Stok: <?= $item['stock'] ?></option>
                <?php endwhile; ?>
            </select>

            <input type="number" name="quantity" placeholder="Jumlah beli" required
                class="w-full mb-3 p-2 border rounded" />

            <label class="block mb-2">Ongkir (Rp)
                <input type="number" name="shipping_cost" class="w-full mb-3 p-2 border rounded" value="0" required>
            </label>


            <button name="submit" class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Beli</button>
        </form>
    </div>
</body>

</html>