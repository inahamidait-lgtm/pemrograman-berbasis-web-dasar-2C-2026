<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

$query = "
SELECT 
    peminjaman.id,
    users.nama,
    books.judul,
    peminjaman.tanggal_pinjam,
    peminjaman.tanggal_kembali,
    peminjaman.status,

    -- hitung selisih hari
    DATEDIFF(peminjaman.tanggal_kembali, peminjaman.tanggal_pinjam) AS total_hari,

    -- hitung denda
    CASE
        WHEN DATEDIFF(peminjaman.tanggal_kembali, peminjaman.tanggal_pinjam) > 7
        THEN (DATEDIFF(peminjaman.tanggal_kembali, peminjaman.tanggal_pinjam) - 7) * 5000
        ELSE 0
    END AS denda

FROM peminjaman

JOIN users 
ON peminjaman.user_id = users.id

JOIN books 
ON peminjaman.book_id = books.id

ORDER BY peminjaman.id DESC
";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-yellow-500 shadow-lg p-4">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-white text-2xl font-bold">
            📋 Riwayat Peminjaman
        </h1>

        <a
            href="dashboard_admin.php"
            class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition"
        >
            Dashboard
        </a>

    </div>

</nav>

<div class="max-w-7xl mx-auto mt-10 px-6">

    <div class="bg-white rounded-2xl shadow-lg p-6">

        <h2 class="text-3xl font-bold text-yellow-600 mb-6">
            Data Riwayat Peminjaman
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border border-gray-300">

                <thead class="bg-yellow-500 text-white">

                    <tr>
                        <th class="p-4 border">No</th>
                        <th class="p-4 border">Nama User</th>
                        <th class="p-4 border">Judul Buku</th>
                        <th class="p-4 border">Tanggal Pinjam</th>
                        <th class="p-4 border">Tanggal Kembali</th>
                        <th class="p-4 border">Total Hari</th>
                        <th class="p-4 border">Denda</th>
                        <th class="p-4 border">Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while($data = mysqli_fetch_assoc($result)) :
                ?>

                    <tr class="text-center hover:bg-gray-100">

                        <td class="p-3 border">
                            <?= $no++; ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($data['nama']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($data['judul']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($data['tanggal_pinjam']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($data['tanggal_kembali']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($data['total_hari']); ?> Hari
                        </td>

                        <td class="p-3 border font-bold text-red-600">

                            <?php if($data['denda'] > 0) : ?>

                                Rp <?= number_format($data['denda'], 0, ',', '.'); ?>

                            <?php else : ?>

                                Tidak Ada

                            <?php endif; ?>

                        </td>

                        <td class="p-3 border">

                            <?php if($data['status'] == 'Dipinjam') : ?>

                                <span class="bg-green-500 text-white px-3 py-1 rounded-lg">
                                    <?= htmlspecialchars($data['status']); ?>
                                </span>

                            <?php else : ?>

                                <span class="bg-blue-500 text-white px-3 py-1 rounded-lg">
                                    <?= htmlspecialchars($data['status']); ?>
                                </span>

                            <?php endif; ?>

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