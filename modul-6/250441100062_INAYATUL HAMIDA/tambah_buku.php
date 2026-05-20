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

if(isset($_POST['simpan'])){

    $judul = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $kategori = htmlspecialchars($_POST['kategori']);

    $tahun = (int) $_POST['tahun'];
    $stok = (int) $_POST['stok'];

    $stmt = $conn->prepare(
        "INSERT INTO books
        (judul, penulis, kategori, tahun_terbit, stok)
        VALUES(?,?,?,?,?)"
    );

    $stmt->bind_param(
        "ssssi",
        $judul,
        $penulis,
        $kategori,
        $tahun,
        $stok
    );

    if($stmt->execute()){

        echo "
        <script>
            alert('Buku berhasil ditambahkan');
            window.location='index.php';
        </script>
        ";

        exit;

    } else {

        echo "
        <script>
            alert('Gagal menambahkan buku');
        </script>
        ";

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-blue-700 shadow-lg p-4">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-white text-2xl font-bold">
            📚 Tambah Buku
        </h1>

        <a
            href="dashboard_admin.php"
            class="bg-white text-blue-700 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition"
        >
            Dashboard
        </a>

    </div>

</nav>

<div class="max-w-2xl mx-auto mt-10">

    <div class="bg-white p-8 rounded-2xl shadow-lg">

        <h2 class="text-3xl font-bold text-blue-700 mb-6 text-center">
            Form Tambah Buku
        </h2>

        <form method="POST">

            <div class="mb-5">

                <label class="block mb-2 font-semibold text-gray-700">
                    Judul Buku
                </label>

                <input
                    type="text"
                    name="judul"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-semibold text-gray-700">
                    Penulis
                </label>

                <input
                    type="text"
                    name="penulis"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-semibold text-gray-700">
                    Kategori
                </label>

                <input
                    type="text"
                    name="kategori"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >

            </div>

            <div class="mb-5">

                <label class="block mb-2 font-semibold text-gray-700">
                    Tahun Terbit
                </label>

                <input
                    type="number"
                    name="tahun"
                    min="1900"
                    max="2099"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >

            </div>

            <div class="mb-6">

                <label class="block mb-2 font-semibold text-gray-700">
                    Stok Buku
                </label>

                <input
                    type="number"
                    name="stok"
                    min="1"
                    required
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >

            </div>

            <div class="flex gap-4">

                <button
                    type="submit"
                    name="simpan"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition"
                >
                    💾 Simpan Buku
                </button>

                <a
                    href="index.php"
                    class="w-full bg-gray-400 hover:bg-gray-500 text-white font-semibold py-3 rounded-lg transition text-center"
                >
                    ↩ Kembali
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>