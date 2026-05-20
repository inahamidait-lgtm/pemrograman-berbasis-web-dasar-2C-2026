<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

$query = $conn->prepare(
    "SELECT 
        peminjaman.*,
        books.judul,
        books.penulis,
        books.kategori
     FROM peminjaman
     JOIN books ON peminjaman.book_id = books.id
     WHERE peminjaman.user_id = ?
     ORDER BY peminjaman.id DESC"
);

$query->bind_param("i", $_SESSION['id']);
$query->execute();

$result = $query->get_result();

$dataUser = $result->fetch_assoc();

$result->data_seek(0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Peminjaman</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-green-600 shadow-lg p-4">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-white text-2xl font-bold">
            📚 Hasil Peminjaman
        </h1>

        <a
            href="logout.php"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition"
        >
            Logout
        </a>

    </div>

</nav>

<div class="max-w-6xl mx-auto mt-10 px-6">

    <div class="bg-white rounded-2xl shadow-lg p-8">

        <div class="mb-8">

            <h2 class="text-3xl font-bold text-green-600 mb-2">
                📖 Data Peminjaman Buku
            </h2>

            <p class="text-gray-500">
                Berikut daftar buku yang berhasil dipinjam
            </p>

        </div>

        <?php if($dataUser){ ?>

        <div class="grid md:grid-cols-2 gap-6 mb-8">

            <div class="bg-gray-100 p-5 rounded-xl">

                <p class="text-gray-500 mb-1">
                    Nama Peminjam
                </p>

                <h3 class="text-xl font-bold text-gray-700">
                    <?= htmlspecialchars($dataUser['nama_peminjam']); ?>
                </h3>

            </div>

            <div class="bg-gray-100 p-5 rounded-xl">

                <p class="text-gray-500 mb-1">
                    NIM Peminjam
                </p>

                <h3 class="text-xl font-bold text-gray-700">
                    <?= htmlspecialchars($dataUser['nim']); ?>
                </h3>

            </div>

        </div>

        <?php } ?>

        <div class="overflow-x-auto">

            <table class="w-full border border-gray-300 rounded-lg overflow-hidden">

                <thead class="bg-green-600 text-white">

                    <tr>
                        <th class="p-4 border">No</th>
                        <th class="p-4 border">Judul Buku</th>
                        <th class="p-4 border">Penulis</th>
                        <th class="p-4 border">Kategori</th>
                        <th class="p-4 border">Tanggal Pinjam</th>
                        <th class="p-4 border">Tanggal Kembali</th>
                        <th class="p-4 border">Denda</th>
                        <th class="p-4 border">Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while($row = $result->fetch_assoc()){
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
                            <?= htmlspecialchars($row['tanggal_pinjam']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($row['tanggal_kembali']); ?>
                        </td>

                        <td class="p-3 border">

                            <?php if($row['denda'] > 0){ ?>

                                <span class="bg-red-500 text-white px-3 py-1 rounded-lg">
                                    Rp <?= number_format($row['denda'], 0, ',', '.'); ?>
                                </span>

                            <?php } else { ?>

                                <span class="bg-green-500 text-white px-3 py-1 rounded-lg">
                                    Tidak Ada
                                </span>

                            <?php } ?>

                        </td>

                        <td class="p-3 border">

                            <span class="bg-blue-500 text-white px-3 py-1 rounded-lg">
                                <?= htmlspecialchars($row['status']); ?>
                            </span>

                        </td>

                    </tr>

                <?php } ?>

                </tbody>

            </table>

        </div>

        <div class="flex flex-wrap gap-4 mt-8">

            <a
                href="index.php"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold transition"
            >
                📚 Pinjam Lagi
            </a>

            <a
                href="dashboard_user.php"
                class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-xl font-semibold transition"
            >
                🏠 Dashboard
            </a>

            <a
                href="logout.php"
                class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-xl font-semibold transition"
            >
                🚪 Logout
            </a>

        </div>

    </div>

</div>

</body>
</html>