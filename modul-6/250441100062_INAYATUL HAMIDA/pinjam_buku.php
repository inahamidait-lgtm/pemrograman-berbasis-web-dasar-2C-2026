<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
}

if($_SESSION['role'] != 'user'){
    die("Akses ditolak");
}

if(!isset($_SESSION['keranjang'])){
    $_SESSION['keranjang'] = [];
}

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $cek = false;

    foreach($_SESSION['keranjang'] as $item){
        if($item['id'] == $id){
            $cek = true;
        }
    }

    if(!$cek){

        $query = $conn->prepare(
            "SELECT * FROM books WHERE id=?"
        );

        $query->bind_param("i", $id);
        $query->execute();

        $result = $query->get_result();
        $buku = $result->fetch_assoc();

        if($buku){
            $_SESSION['keranjang'][] = $buku;
        }
    }

    header("Location: pinjam_buku.php");
    exit;
}

if(isset($_GET['hapus'])){

    $index = $_GET['hapus'];

    unset($_SESSION['keranjang'][$index]);

    $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);

    header("Location: pinjam_buku.php");
    exit;
}

if(isset($_POST['simpan'])){

    if(empty($_SESSION['keranjang'])){

        echo "
        <script>
            alert('Belum ada buku dipilih');
            window.location='pinjam_buku.php';
        </script>
        ";

        exit;
    }

    $nama = $_POST['nama'];
    $nim = $_POST['nim'];
    $tanggal_pinjam = $_POST['tanggal_pinjam'];
    $tanggal_kembali = $_POST['tanggal_kembali'];

    $_SESSION['nama_peminjam'] = $nama;
    $_SESSION['nim'] = $nim;
    $_SESSION['tanggal_pinjam'] = $tanggal_pinjam;
    $_SESSION['tanggal_kembali'] = $tanggal_kembali;

    $tgl1 = new DateTime($tanggal_pinjam);
    $tgl2 = new DateTime($tanggal_kembali);

    $selisih = $tgl1->diff($tgl2)->days;

    $denda = 0;

    if($selisih > 7){

        $hari_telat = $selisih - 7;

        $denda = $hari_telat * 5000;
    }

    $_SESSION['denda'] = $denda;

    foreach($_SESSION['keranjang'] as $item){

        $status = "Dipinjam";

        $stmt = $conn->prepare(
            "INSERT INTO peminjaman
            (
                user_id,
                book_id,
                nama_peminjam,
                nim,
                tanggal_pinjam,
                tanggal_kembali,
                denda,
                status
            )
            VALUES(?,?,?,?,?,?,?,?)"
        );

        $stmt->bind_param(
            "iissssis",
            $_SESSION['id'],
            $item['id'],
            $nama,
            $nim,
            $tanggal_pinjam,
            $tanggal_kembali,
            $denda,
            $status
        );

        $stmt->execute();

        $update = $conn->prepare(
            "UPDATE books
             SET stok = stok - 1
             WHERE id=?"
        );

        $update->bind_param("i", $item['id']);
        $update->execute();
    }

    echo "
    <script>
        alert('Data berhasil disimpan');
        window.location='pinjam_buku.php';
    </script>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pinjam Buku</title>

<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-blue-600 shadow-lg p-4">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-white text-2xl font-bold">
            📚 Form Peminjaman Buku
        </h1>

        <a
            href="dashboard_user.php"
            class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition"
        >
            Dashboard
        </a>

    </div>

</nav>

<div class="max-w-7xl mx-auto mt-10 px-6">

    <div class="bg-white rounded-2xl shadow-lg p-8">

        <div class="mb-8">

            <h2 class="text-3xl font-bold text-blue-600 mb-2">
                📖 Data Peminjaman
            </h2>

            <p class="text-gray-500">
                Silakan isi data peminjaman buku
            </p>

        </div>

        <form method="POST">

            <div class="grid md:grid-cols-2 gap-6">

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Nama Peminjam
                    </label>

                    <input
                        type="text"
                        name="nama"
                        required
                        value="<?= $_SESSION['nama_peminjam'] ?? ''; ?>"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        NIM
                    </label>

                    <input
                        type="text"
                        name="nim"
                        required
                        value="<?= $_SESSION['nim'] ?? ''; ?>"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Pinjam
                    </label>

                    <input
                        type="date"
                        name="tanggal_pinjam"
                        required
                        value="<?= $_SESSION['tanggal_pinjam'] ?? ''; ?>"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>

                <div>

                    <label class="block mb-2 font-semibold text-gray-700">
                        Tanggal Pengembalian
                    </label>

                    <input
                        type="date"
                        name="tanggal_kembali"
                        required
                        value="<?= $_SESSION['tanggal_kembali'] ?? ''; ?>"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                </div>

            </div>

            <button
                type="submit"
                name="simpan"
                class="mt-6 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition"
            >
                💾 Simpan Data
            </button>

        </form>

        <div class="overflow-x-auto mt-10">

            <table class="w-full border border-gray-300 rounded-xl overflow-hidden">

                <thead class="bg-blue-600 text-white">

                    <tr>
                        <th class="p-4 border">No</th>
                        <th class="p-4 border">Judul Buku</th>
                        <th class="p-4 border">Penulis</th>
                        <th class="p-4 border">Kategori</th>
                        <th class="p-4 border">Tanggal Pinjam</th>
                        <th class="p-4 border">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                foreach($_SESSION['keranjang'] as $index => $item):
                ?>

                    <tr class="text-center hover:bg-gray-100 transition">

                        <td class="p-3 border">
                            <?= $no++; ?>
                        </td>

                        <td class="p-3 border font-semibold">
                            <?= htmlspecialchars($item['judul']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($item['penulis']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($item['kategori']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= $_SESSION['tanggal_pinjam'] ?? '-'; ?>
                        </td>

                        <td class="p-3 border">

                            <a
                                href="pinjam_buku.php?hapus=<?= $index; ?>"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition"
                            >
                                Hapus
                            </a>

                        </td>

                    </tr>

                <?php endforeach; ?>

                <?php if(empty($_SESSION['keranjang'])): ?>

                    <tr>

                        <td colspan="6" class="p-6 text-center text-gray-500">
                            Belum ada buku dipilih
                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

        <div class="mt-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg">

            <p class="font-semibold">
                ⚠ Ketentuan Denda
            </p>

            <p class="mt-1">
                Jika pengembalian lebih dari 7 hari,
                maka dikenakan denda Rp 5.000 per hari per buku.
            </p>

        </div>

        <div class="flex flex-wrap gap-4 mt-8">

            <a
                href="index.php"
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-xl font-semibold transition"
            >
                ➕ Tambah Buku
            </a>

            <a
                href="hasil_pinjaman.php"
                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold transition"
            >
                ✅ Selesai
            </a>

        </div>

    </div>

</div>

</body>
</html>