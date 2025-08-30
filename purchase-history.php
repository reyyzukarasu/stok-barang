<?php
require_once "session.php";
require_once "config/db.php";

$data = $conn->query("
  SELECT p.*, i.name FROM purchases p
  JOIN items i ON p.item_id = i.id
  ORDER BY p.purchase_date DESC
");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Riwayat Pembelian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6 bg-gray-100">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold mb-4">Riwayat Pembelian</h1>
        <a href="dashboard.php" class="p-4 bg-white rounded shadow hover:bg-blue-50">
            🏠 <strong>Dashboard</strong>
        </a>
    </div>
    <table class="w-full bg-white rounded shadow">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nama Barang</th>
                <th class="px-4 py-2">Jumlah</th>
                <th class="px-4 py-2">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $data->fetch_assoc()): ?>
                <tr class="border-t">
                    <td class="px-4 py-2"><?= $row['name'] ?></td>
                    <td class="px-4 py-2"><?= $row['quantity'] ?></td>
                    <td class="px-4 py-2"><?= $row['purchase_date'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="export-purchase-pdf.php" target="_blank"
        class="inline-block mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
        🧾 Ekspor PDF
    </a>

</body>

</html>