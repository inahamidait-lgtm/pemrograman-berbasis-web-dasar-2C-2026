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

if(isset($_GET['hapus'])){

    $id = $_GET['hapus'];

    if($id == $_SESSION['id']){
        echo "
        <script>
            alert('Akun admin yang sedang login tidak bisa dihapus!');
            window.location='data_user.php';
        </script>
        ";
        exit;
    }

    $hapusPinjam = $conn->prepare(
        "DELETE FROM peminjaman WHERE user_id=?"
    );

    $hapusPinjam->bind_param("i", $id);
    $hapusPinjam->execute();

    $hapusUser = $conn->prepare(
        "DELETE FROM users WHERE id=?"
    );

    $hapusUser->bind_param("i", $id);

    if($hapusUser->execute()){

        echo "
        <script>
            alert('Data user berhasil dihapus!');
            window.location='data_user.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Gagal menghapus user!');
        </script>
        ";

    }
}

$query = mysqli_query(
    $conn,
    "SELECT * FROM users ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Data User</title>

<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<nav class="bg-yellow-500 p-4 shadow-lg">

    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <h1 class="text-white text-2xl font-bold">
            👤 Data User
        </h1>

        <a
            href="dashboard_admin.php"
            class="bg-white text-yellow-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-200 transition"
        >
            Dashboard
        </a>

    </div>

</nav>

<div class="max-w-7xl mx-auto mt-10 px-6">

    <div class="bg-white rounded-2xl shadow-lg p-6">

        <h2 class="text-3xl font-bold text-yellow-600 mb-6">
            Daftar User
        </h2>

        <div class="overflow-x-auto">

            <table class="w-full border border-gray-300">

                <thead class="bg-yellow-500 text-white">

                    <tr>
                        <th class="p-4 border">No</th>
                        <th class="p-4 border">Nama</th>
                        <th class="p-4 border">Email</th>
                        <th class="p-4 border">Role</th>
                        <th class="p-4 border">Aksi</th>
                    </tr>

                </thead>

                <tbody>

                <?php
                $no = 1;

                while($user = mysqli_fetch_assoc($query)) :
                ?>

                    <tr class="text-center hover:bg-gray-100 transition">

                        <td class="p-3 border">
                            <?= $no++; ?>
                        </td>

                        <td class="p-3 border font-semibold">
                            <?= htmlspecialchars($user['nama']); ?>
                        </td>

                        <td class="p-3 border">
                            <?= htmlspecialchars($user['email']); ?>
                        </td>

                        <td class="p-3 border">

                            <?php if($user['role'] == 'admin') : ?>

                                <span class="bg-blue-500 text-white px-3 py-1 rounded-lg">
                                    Admin
                                </span>

                            <?php else : ?>

                                <span class="bg-green-500 text-white px-3 py-1 rounded-lg">
                                    User
                                </span>

                            <?php endif; ?>

                        </td>

                        <td class="p-3 border">

                            <?php if($user['id'] != $_SESSION['id']) : ?>

                                <a
                                    href="data_user.php?hapus=<?= $user['id']; ?>"
                                    onclick="return confirm('Yakin ingin menghapus user ini?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition"
                                >
                                    Hapus
                                </a>

                            <?php else : ?>

                                <span class="text-gray-500 italic">
                                    Sedang Login
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