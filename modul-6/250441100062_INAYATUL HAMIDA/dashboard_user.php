<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-blue-700 p-4 shadow-lg">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-white text-2xl font-bold">
            📚 Dashboard User
        </h1>

        <a
            href="logout.php"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition"
        >
            Logout
        </a>

    </div>

</nav>

<div class="max-w-7xl mx-auto mt-10 px-6">

    <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">

        <h2 class="text-3xl font-bold text-blue-700 mb-6">
            Selamat Datang 👋
        </h2>

        <div class="flex justify-between items-center border-b pb-4 mb-4">

            <span class="text-lg font-semibold text-gray-700">
                Nama
            </span>

            <span class="text-lg text-gray-600">
                <?= htmlspecialchars($_SESSION['nama']); ?>
            </span>

        </div>

        <div class="flex justify-between items-center border-b pb-4 mb-6">

            <span class="text-lg font-semibold text-gray-700">
                Role
            </span>

            <span class="text-lg text-gray-600 capitalize">
                <?= htmlspecialchars($_SESSION['role']); ?>
            </span>

        </div>

        <a
            href="index.php"
            class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl font-semibold transition"
        >
            📖 Pinjam Buku
        </a>

    </div>

    <div class="max-w-md">

        <a
            href="index.php"
            class="block bg-white hover:bg-blue-50 p-8 rounded-2xl shadow-lg border transition"
        >

            <h3 class="text-2xl font-bold text-blue-700 mb-3">
                📚 Daftar Buku
            </h3>

            <p class="text-gray-600">
                Melihat dan meminjam buku yang tersedia
            </p>

        </a>

    </div>

</div>

</body>
</html>