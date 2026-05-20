<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

if(!isset($_SESSION['pinjaman'])){
    $_SESSION['pinjaman'] = [];
}

if(!isset($_SESSION['nama_peminjam'])){
    $_SESSION['nama_peminjam'] = $_SESSION['nama'] ?? 'User';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Peminjaman</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-5xl mx-auto mt-10 bg-white p-8 rounded-2xl shadow-lg">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-green-600">
            Hasil Peminjaman Buku
        </h1>
    </div>

    <div class="mb-6">
        <p class="text-lg">
            Nama Peminjam : 
            <span class="font-semibold text-gray-700">
                <?= htmlspecialchars($_SESSION['nama_peminjam']); ?>
            </span>
        </p>
        <p class="text-lg">
            NIM Peminjam : 
            <span class="font-semibold text-gray-700">
                <?= htmlspecialchars($_SESSION['nim_peminjam'] ?? '-'); ?>
            </span>
        </p>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full border border-gray-300">
            <thead class="bg-green-500 text-white">
                <tr>
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">Judul Buku</th>
                    <th class="p-3 border">Penulis</th>
                    <th class="p-3 border">Kategori</th>
                    <th class="p-3 border">Tanggal Pinjam</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            if(count($_SESSION['pinjaman']) > 0){
                foreach($_SESSION['pinjaman'] as $pinjam){
            ?>
                <tr class="text-center hover:bg-gray-100">
                    <td class="p-3 border"><?= $no++; ?></td>
                    <td class="p-3 border"><?= htmlspecialchars($pinjam['judul']); ?></td>
                    <td class="p-3 border"><?= htmlspecialchars($pinjam['penulis']); ?></td>
                    <td class="p-3 border"><?= htmlspecialchars($pinjam['kategori']); ?></td>
                    <td class="p-3 border"><?= htmlspecialchars($pinjam['tanggal']); ?></td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td colspan="5" class="p-4 text-center text-gray-500">
                        Belum ada buku yang dipinjam
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex gap-4">
        <a href="index.php" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg transition">
            Pinjam Lagi
        </a>

        <a href="dashboard.php" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition">
            Dashboard
        </a>

        <button 
            onclick="confirmLogout()" 
            class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg transition"
        >
            Logout
        </button>
    </div>
</div>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Sesi Anda akan berakhir!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Logout berhasil dilakukan.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'logout.php';
                });
            }
        })
    }
</script>

</body>
</html>