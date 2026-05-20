<?php
ob_start(); 
include __DIR__ . '/cek.login.php'; 
ob_clean(); 

include __DIR__ . '/koneksi.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
    die("Akses ditolak. Anda bukan Admin.");
}

$id = isset($_GET['id']) ? $_GET['id'] : '';

if(empty($id)){
    echo "<script>alert('ID Buku tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

$stmt = $conn->prepare(
    "SELECT * FROM books WHERE id=?"
);

$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$data = $result->fetch_assoc();

if(!$data){
    echo "<script>alert('Data buku tidak ditemukan!'); window.location='index.php';</script>";
    exit;
}

if(isset($_POST['update'])){

    $judul = htmlspecialchars($_POST['judul']);
    $penulis = htmlspecialchars($_POST['penulis']);
    $kategori = htmlspecialchars($_POST['kategori']);

    $tahun = $_POST['tahun'];
    $stok = $_POST['stok'];

    $update = $conn->prepare(
        "UPDATE books
         SET judul=?,
             penulis=?,
             kategori=?,
             tahun_terbit=?,
             stok=?
         WHERE id=?"
    );

    $update->bind_param(
        "sssiii",
        $judul,
        $penulis,
        $kategori,
        $tahun,
        $stok,
        $id
    );

    if($update->execute()){
        echo "
        <script>
            alert('Data buku berhasil diupdate');
            window.location='index.php';
        </script>
        ";
        exit;
    } else {
        echo "
        <script>
            alert('Gagal update buku');
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
    <title>Edit Buku</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-yellow-500 shadow-lg p-4">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <h1 class="text-white text-2xl font-bold">
            ✏️ Edit Buku
        </h1>
        <a
            href="index.php"
            class="bg-white text-yellow-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition"
        >
            Kembali
        </a>
    </div>
</nav>

<div class="max-w-2xl mx-auto mt-10 px-4">

    <div class="bg-white p-8 rounded-2xl shadow-lg">

        <h2 class="text-3xl font-bold text-yellow-600 mb-6 text-center">
            Form Edit Buku
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
                    value="<?= htmlspecialchars($data['judul'] ?? ''); ?>"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
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
                    value="<?= htmlspecialchars($data['penulis'] ?? ''); ?>"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
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
                    value="<?= htmlspecialchars($data['kategori'] ?? ''); ?>"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
            </div>

            <div class="mb-5">
                <label class="block mb-2 font-semibold text-gray-700">
                    Tahun Terbit
                </label>
                <input
                    type="number"
                    name="tahun"
                    required
                    value="<?= htmlspecialchars($data['tahun_terbit'] ?? ''); ?>"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
            </div>

            <div class="mb-6">
                <label class="block mb-2 font-semibold text-gray-700">
                    Stok Buku
                </label>
                <input
                    type="number"
                    name="stok"
                    required
                    value="<?= htmlspecialchars($data['stok'] ?? ''); ?>"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-yellow-400"
                >
            </div>

            <button
                type="submit"
                name="update"
                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 rounded-lg transition shadow-md"
            >
                💾 Update Buku
            </button>

        </form>

    </div>

</div>

</body>
</html>