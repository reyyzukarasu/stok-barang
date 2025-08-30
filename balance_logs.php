<?php
require_once "session.php";
require_once "config/db.php";

$result = $conn->query("SELECT * FROM balance_logs ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Riwayat Saldo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <a href="dashboard.php" class="p-4 bg-white rounded shadow hover:bg-blue-50 mb-4 inline-block">🏠 Dashboard</a>

    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">Riwayat Top Up & Tarik Saldo</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border">
                <thead class="bg-gray-200 text-sm">
                    <tr>
                        <th class="border px-4 py-2">#</th>
                        <th class="border px-4 py-2">Tipe</th>
                        <th class="border px-4 py-2">Metode</th>
                        <th class="border px-4 py-2">Jumlah</th>
                        <th class="border px-4 py-2">Bukti</th>
                        <th class="border px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    <?php $no = 1;
                    while ($row = $result->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="border px-4 py-2 text-center"><?= $no++ ?></td>
                            <td class="border px-4 py-2 text-center"><?= ucfirst($row['type']) ?></td>
                            <td class="border px-4 py-2 text-center"><?= ucfirst($row['method']) ?></td>
                            <td class="border px-4 py-2 text-right text-green-700 font-semibold">
                                Rp<?= number_format($row['amount']) ?></td>
                            <td class="border px-4 py-2 text-center">
                                <?php if ($row['proof']): ?>
                                    <button onclick="showImage('<?= $row['proof'] ?>')"
                                        class="text-blue-600 underline hover:text-blue-800">Lihat</button>
                                <?php else: ?>
                                    <span class="text-gray-400 italic">-</span>
                                <?php endif; ?>
                            </td>

                            <td class="border px-4 py-2 text-center"><?= date("d M Y H:i", strtotime($row['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Modal viewer -->
            <div id="imageModal"
                class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded shadow-lg p-4 max-w-3xl w-full relative">
                    <button onclick="closeModal()" class="absolute top-2 right-2 text-red-500 text-2xl">&times;</button>
                    <img id="modalImage" src="" alt="Bukti" class="mx-auto max-h-[80vh]">
                </div>
            </div>

        </div>
        <a href="cetak-riwayat-saldo.php" target="_blank"
            class="inline-block mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            🖨️ Cetak PDF
        </a>
    </div>

    <script>
        function showImage(url) {
            document.getElementById('modalImage').src = url;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.getElementById('modalImage').src = "";
        }

        // Optional: Tutup modal saat klik luar gambar
        window.addEventListener('click', function (e) {
            const modal = document.getElementById('imageModal');
            const image = document.getElementById('modalImage');
            if (e.target === modal) closeModal();
        });
    </script>

</body>

</html>