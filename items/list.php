<?php
require_once "../session.php";
require_once "../config/db.php";

$items = $conn->query("SELECT * FROM items");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Daftar Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6 bg-gray-100">

    <div class="flex justify-between items-center mb-4">
        <a href="../dashboard.php" class="p-4 bg-white rounded shadow hover:bg-blue-50">
            🏠 <strong>Dashboard</strong>
        </a>
        <h1 class="text-xl font-bold">Daftar Barang</h1>
        <a href="add.php" class="bg-blue-500 text-white px-3 py-1 rounded">+ Tambah</a>
    </div>

    <table class="w-full bg-white rounded shadow">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Harga Beli</th>
                <th class="px-4 py-2">Keuntungan</th>
                <th class="px-4 py-2">Stok</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $items->fetch_assoc()): ?>
                <tr class="border-t">
                    <td class="px-4 py-2"><?= $row['name'] ?></td>
                    <td class="px-4 py-2">Rp<?= number_format($row['purchase_price']) ?></td>
                    <td class="px-4 py-2">Rp<?= number_format($row['profit']) ?></td>
                    <td class="px-4 py-2"><?= $row['stock'] ?></td>
                    <td class="px-4 py-2">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="text-blue-500 hover:underline">Edit</a> |
                        <a href="delete.php?id=<?= $row['id'] ?>" class="text-red-500 hover:underline"
                            onclick="return confirm('Yakin mau hapus?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>

</html>