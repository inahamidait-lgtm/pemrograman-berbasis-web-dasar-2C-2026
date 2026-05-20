<?php
session_start();
include 'koneksi.php';

// cek login
if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

// cek role admin
if($_SESSION['role'] != 'admin'){
    die("Akses ditolak");
}

// ambil data buku
$query = mysqli_query(
    $conn,
    "SELECT * FROM books ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Buku</title>

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<!-- Navbar -->
<nav class="bg-blue-700 p-4 shadow-lg">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-white text-2xl font-bold">
            📚 Kelola Buku
        </h1>

        <a
            href="dashboard_admin.php"
            class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition"
        >
            Dashboard
        </a>

    </div>

</nav>

<!-- Content -->
<div class="max-w-7xl mx-auto mt-10 px-6">

    <!-- Tombol tambah -->
    <div class="mb-6">

        <a
            href="tambah_buku.php"
            class="bg-green-500 hover:bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg"
        >
            ➕ Tambah Buku
        </a>

    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-lg p-6 overflow-x-auto">

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

            while($data = mysqli_fetch_assoc($query)) :
            ?>

                <tr class="text-center hover:bg-gray-100">

                    <td class="p-3 border">
                        <?= $no++; ?>
                    </td>

                    <td class="p-3 border">
                        <?= htmlspecialchars($data['judul']); ?>
                    </td>

                    <td class="p-3 border">
                        <?= htmlspecialchars($data['penulis']); ?>
                    </td>

                    <td class="p-3 border">
                        <?= htmlspecialchars($data['kategori']); ?>
                    </td>

                    <td class="p-3 border">
                        <?= htmlspecialchars($data['tahun_terbit']); ?>
                    </td>

                    <td class="p-3 border">
                        <?= htmlspecialchars($data['stok']); ?>
                    </td>

                    <td class="p-3 border">

                    <div class="flex justify-center gap-3">

                    <!-- Edit -->
                    <a
                        href="edit_buku.php?id=<?= $data['id']; ?>"
                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-4 py-2 rounded-lg"
                    >
                        Edit
                    </a>

                    <!-- Hapus -->
                    <a
                        href="hapus_buku.php?id=<?= $data['id']; ?>"
                        onclick="return confirm('Yakin ingin menghapus buku ini?')"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg"
                    >
                        Hapus
                    </a>

                    </div>

                </td>

                </tr>

            <?php endwhile; ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>