<?php
require_once "../session.php";
require_once "../config/db.php";

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM items WHERE id=$id");
$item = $result->fetch_assoc();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $price = $_POST['purchase_price'];
    $profit = $_POST['profit'];
    $stock = $_POST['stock'];

    $conn->query("UPDATE items SET name='$name', purchase_price='$price',
                 profit='$profit', stock='$stock' WHERE id=$id");
    header("Location: list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-6 bg-gray-100">
    <form method="POST" class="bg-white p-6 rounded shadow-md w-96 mx-auto">
        <h2 class="text-xl font-bold mb-4">Edit Barang</h2>
        <input type="text" name="name" value="<?= $item['name'] ?>" required class="w-full mb-3 p-2 border rounded" />
        <input type="number" name="purchase_price" value="<?= $item['purchase_price'] ?>" required
            class="w-full mb-3 p-2 border rounded" />
        <input type="number" name="profit" value="<?= $item['profit'] ?>" required
            class="w-full mb-3 p-2 border rounded" />
        <input type="number" name="stock" value="<?= $item['stock'] ?>" required
            class="w-full mb-3 p-2 border rounded" />
        <button type="submit" name="submit"
            class="w-full bg-blue-500 text-white p-2 rounded hover:bg-blue-600">Update</button>
    </form>
</body>

</html>