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

// cek id buku
if(!isset($_GET['id'])){
    die("ID buku tidak ditemukan");
}

$id = $_GET['id'];

// hapus buku
$stmt = $conn->prepare(
    "DELETE FROM books WHERE id=?"
);

$stmt->bind_param("i", $id);

if($stmt->execute()){

    echo "
    <script>
        alert('Buku berhasil dihapus');
        window.location='kelola_buku.php';
    </script>
    ";

    exit;

} else {

    echo "
    <script>
        alert('Gagal menghapus buku');
        window.location='kelola_buku.php';
    </script>
    ";

}
?>