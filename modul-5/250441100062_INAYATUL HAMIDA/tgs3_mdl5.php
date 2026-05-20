<?php
$artikel = [
    "html" => [
        "judul" => "Belajar HTML Pertama Kali",
        "tanggal" => "13 Maret 2026",
        "isi" => "Saat pertama belajar HTML, saya mulai memahami struktur dasar website seperti heading, paragraf, dan link. Ini menjadi fondasi penting dalam dunia web development.",
        "gambar" => "image.png",
        "link" => "https://developer.mozilla.org/id/docs/Web/HTML"
    ],
    "error" => [
        "judul" => "Error Pertama",
        "tanggal" => "5 Mei 2026",
        "isi" => "Mengalami error pertama membuat saya belajar membaca pesan error dan debugging. Dari sini saya tahu bahwa error adalah bagian penting dari proses belajar coding.",
        "gambar" => "image1.png",
        "link" => "https://stackoverflow.com"
    ],
    "js" => [
        "judul" => "Belajar JavaScript",
        "tanggal" => "08 April 2026",
        "isi" => "JavaScript membuka wawasan saya tentang interaktivitas website. Saya mulai membuat tombol, alert, dan validasi form.",
        "gambar" => "image3.png",
        "link" => "https://developer.mozilla.org/id/docs/Web/JavaScript"
    ]
];

$quotes = [
    "Coding itu bukan tentang tidak pernah error, tapi bagaimana kamu memperbaikinya.",
    "Practice makes perfect programmer.",
    "Jangan menyerah hanya karena bug.",
    "Setiap error adalah pelajaran baru.",
    "Koding hari ini, sukses esok hari."
];

$randomQuote = $quotes[array_rand($quotes)];

$pilih = isset($_GET['artikel']) ? $_GET['artikel'] : null;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog Developer</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #333;
    }

    .container {
        display: flex;
        max-width: 900px;
        margin: 20px auto;
        gap: 20px;
    }

    .menu {
        width: 30%;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .menu h3 {
        margin-top: 0;
    }

    .menu a {
        display: block;
        margin: 8px 0;
        padding: 8px;
        text-decoration: none;
        color: #333;
        border-radius: 5px;
        transition: 0.2s;
    }

    .menu a:hover {
        background: #6a0dad;
        color: white;
    }

    .konten {
        width: 70%;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .konten h3 {
        margin-top: 0;
        color: #6a0dad;
    }

    .konten small {
        color: gray;
    }

    .konten p {
        line-height: 1.6;
    }

    img {
        max-width: 100%;
        border-radius: 8px;
        margin-top: 10px;
    }

    .quote {
        margin-top: 20px;
        padding: 15px;
        background: #e8f5e9;
        border-left: 5px solid green;
        font-style: italic;
        border-radius: 5px;
    }

    .nav {
        text-align: center;
        margin-top: 30px;
    }

    .nav a {
        margin: 5px;
        text-decoration: none;
        padding: 10px 15px;
        background: #6a0dad;
        color: white;
        border-radius: 5px;
        display: inline-block;
    }

    .nav a:hover {
        background: #4b0082;
    }
</style>
</head>
<body>

<h2>Blog Reflektif Developer</h2>

<div class="container">

    <div class="menu">
        <h3>Daftar Artikel</h3>
        <?php foreach ($artikel as $key => $data) : ?>
            <a href="?artikel=<?= $key; ?>">
                <?= $data['judul']; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <div class="konten">
        <?php if ($pilih && isset($artikel[$pilih])) : 
            $data = $artikel[$pilih];
        ?>
            <h3><?= $data['judul']; ?></h3>
            <small><?= $data['tanggal']; ?></small>
            <p><?= $data['isi']; ?></p>

            <img src="<?= $data['gambar']; ?>" alt="gambar">

            <p>
                Referensi:
                <a href="<?= $data['link']; ?>" target="_blank">
                    Klik di sini
                </a>
            </p>
        <?php else : ?>
            <p>Pilih artikel untuk melihat detail.</p>
        <?php endif; ?>

        <div class="quote">
            <b>Kutipan Motivasi:</b><br>
            <?= $randomQuote; ?>
        </div>
    </div>

</div>

<div class="nav">
    <a href="tgs2_mdl5.php">timeline</a>
    <a href="tgs1_mdl5.php">profil</a>
</div>

</body>
</html>