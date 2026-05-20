<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$queryBuku = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM books"
);

$buku = mysqli_fetch_assoc($queryBuku);

$queryPinjam = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM peminjaman"
);

$pinjam = mysqli_fetch_assoc($queryPinjam);

$queryUser = mysqli_query(
    $conn,
    "SELECT COUNT(*) as total FROM users"
);

$user = mysqli_fetch_assoc($queryUser);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-blue-700 p-4 shadow-lg">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-white text-2xl font-bold">
            📚 Dashboard Admin
        </h1>

        <a
            href="logout.php"
            class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl transition"
        >
            Logout
        </a>

    </div>

</nav>

<div class="max-w-7xl mx-auto mt-10 px-6">

    <div class="bg-white p-8 rounded-3xl shadow-lg mb-10">

        <h2 class="text-3xl font-bold text-blue-700 mb-4">
            Selamat Datang Admin 👋
        </h2>

        <p class="text-lg mb-2">
            Nama :
            <span class="font-semibold text-gray-700">
                <?= htmlspecialchars($_SESSION['nama']); ?>
            </span>
        </p>

        <p class="text-lg">
            Role :
            <span class="font-semibold text-gray-700">
                <?= htmlspecialchars($_SESSION['role']); ?>
            </span>
        </p>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

        <div class="bg-blue-600 text-white p-6 rounded-3xl shadow-lg">

            <h3 class="text-xl font-semibold mb-3">
                📘 Total Buku
            </h3>

            <p class="text-5xl font-bold">
                <?= $buku['total']; ?>
            </p>

        </div>

        <div class="bg-green-600 text-white p-6 rounded-3xl shadow-lg">

            <h3 class="text-xl font-semibold mb-3">
                📖 Total Peminjaman
            </h3>

            <p class="text-5xl font-bold">
                <?= $pinjam['total']; ?>
            </p>

        </div>

        <a
            href="data_user.php"
            class="bg-yellow-500 hover:bg-yellow-600 text-white p-6 rounded-3xl shadow-lg transition block"
        >

            <h3 class="text-xl font-semibold mb-3">
                👤 Total User
            </h3>

            <p class="text-5xl font-bold">
                <?= $user['total']; ?>
            </p>

            <p class="mt-4 text-sm">
                Klik untuk melihat data user
            </p>

        </a>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <a
            href="kelola_buku.php"
            class="bg-white hover:bg-blue-50 p-8 rounded-3xl shadow-lg border transition"
        >

            <div class="text-5xl mb-4">
                📚
            </div>

            <h3 class="text-2xl font-bold text-blue-700 mb-3">
                Kelola Buku
            </h3>

            <p class="text-gray-600 leading-8">
                Tambah, edit, dan hapus buku
            </p>

        </a>

        <a
            href="tambah_buku.php"
            class="bg-white hover:bg-green-50 p-8 rounded-3xl shadow-lg border transition"
        >

            <div class="text-5xl mb-4">
                ➕
            </div>

            <h3 class="text-2xl font-bold text-green-700 mb-3">
                Tambah Buku
            </h3>

            <p class="text-gray-600 leading-8">
                Menambahkan buku baru
            </p>

        </a>

        <a
            href="lihat_riwayat_pinjam.php"
            class="bg-white hover:bg-yellow-50 p-8 rounded-3xl shadow-lg border transition"
        >

            <div class="text-5xl mb-4">
                📋
            </div>

            <h3 class="text-2xl font-bold text-yellow-700 mb-3">
                Riwayat Pinjam
            </h3>

            <p class="text-gray-600 leading-8">
                Melihat semua peminjaman user
            </p>

        </a>

    </div>

</div>

</body>
</html>