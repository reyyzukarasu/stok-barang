<?php
require_once "../session.php";
require_once "../config/db.php";

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['purchase_price'];
    $profit = $_POST['profit'];
    $stock = $_POST['stock'];

    $conn->query("INSERT INTO items (name, purchase_price, profit, stock)
                VALUES ('$name', '$price', '$profit', '$stock')");
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tambah Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6 bg-gray-100">
    <form method="POST" class="bg-white p-6 rounded shadow-md w-96 mx-auto">
        <h2 class="text-xl font-bold mb-4">Tambah Barang</h2>
        <input type="text" name="name" placeholder="Nama barang" required class="w-full mb-3 p-2 border rounded" />
        <input type="number" name="purchase_price" placeholder="Harga beli" required
            class="w-full mb-3 p-2 border rounded" />
        <input type="number" name="profit" placeholder="Keuntungan" required class="w-full mb-3 p-2 border rounded" />
        <input type="number" name="stock" placeholder="Stok awal" required class="w-full mb-3 p-2 border rounded" />
        <button type="submit" name="submit"
            class="w-full bg-green-500 text-white p-2 rounded hover:bg-green-600">Simpan</button>
    </form>
</body>

</html>