<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$query = "SELECT * FROM books ORDER BY id DESC";
$data = mysqli_query($conn, $query);

if(!$data){
    die("Query Error : " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Buku</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-blue-700 p-4 shadow-lg">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-white text-2xl font-bold">
            📚 Data Buku
        </h1>

        <a
            href="<?= $_SESSION['role'] == 'admin'
                ? 'dashboard_admin.php'
                : 'dashboard_user.php'; ?>"
            class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition"
        >
            Dashboard
        </a>

    </div>

</nav>

<div class="max-w-7xl mx-auto mt-10 px-6">

    <div class="bg-white rounded-2xl shadow-lg p-6">

        <div class="mb-6">

            <h2 class="text-3xl font-bold text-blue-700 mb-2">
                📖 Daftar Buku
            </h2>

            <p class="text-gray-500">
                Pilih buku yang ingin dipinjam
            </p>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full border border-gray-300">

                <thead class="bg-blue-600 text-white">

                    <tr>
                        <th class="p-4 border">No</th>
                        <th class="p-4 border">Judul</th>
                        <th class="p-4 border">Penulis</th>
                        <th class="p-4 border">Kategori</th>
                        <th class="p-4 border">Tahun</th>
                        <th class="p-4 border">Stok</th>
                        <th class="p-4 border">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while($row = mysqli_fetch_assoc($data)) :
                ?>

                    <tr class="text-center hover:bg-gray-100 transition">

                        <td class="p-3 border">
                            <?= $no++; ?>
                        </td>
                       
                        <td class="p-3 border font-semibold">
                            <?= htmlspecialchars($row['judul']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($row['penulis']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($row['kategori']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($row['tahun_terbit']); ?>
                        </td>

                        <td class="p-3 border">

                            <?php if($row['stok'] > 0) { ?>

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    <?= htmlspecialchars($row['stok']); ?>
                                </span>

                            <?php } else { ?>

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    Habis
                                </span>

                            <?php } ?>

                        </td>

                        <td class="p-3 border">

                            <div class="flex justify-center gap-3">

                                <?php if($row['stok'] > 0) { ?>

                                    <a
                                        href="pinjam_buku.php?id=<?= $row['id']; ?>"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition"
                                    >
                                        📚 Pinjam
                                    </a>

                                <?php } else { ?>

                                    <button
                                        class="bg-gray-400 text-white px-4 py-2 rounded-lg cursor-not-allowed"
                                        disabled
                                    >
                                        Stok Habis
                                    </button>

                                <?php } ?>

                            </div>

                        </td>

                    </tr>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>