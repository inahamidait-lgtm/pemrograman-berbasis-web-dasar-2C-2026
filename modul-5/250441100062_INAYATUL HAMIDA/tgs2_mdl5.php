<?php
$timeline = [
    ["tahun" => "2025", "judul" => "Masuk Kuliah", "deskripsi" => "Mulai belajar phyton di semester 1"],
    ["tahun" => "2026", "judul" => "Belajar HTML & CSS", "deskripsi" => "Membuat halaman web sederhana"],
    ["tahun" => "2026", "judul" => "Belajar website", "deskripsi" => "Membuat website portofolio pribadi"],
    ["tahun" => "2026", "judul" => "Belajar JavaScript", "deskripsi" => "Membuat interaksi pada website"],
    ["tahun" => "2026", "judul" => "Belajar php", "deskripsi" => "Mulai menggunakan PHP & database"]
];

function highlightTahun($tahun) {
    if ($tahun >= 2025) {
        return "highlight";
    }
    return "";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Timeline Belajar Coding</title>
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

        .timeline {
            max-width: 600px;
            margin: 30px auto;
            border-left: 4px solid #6a0dad;
            padding-left: 25px;
        }

        .item {
            background: white;
            margin-bottom: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            position: relative;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .item::before {
            content: "";
            width: 14px;
            height: 14px;
            background: #6a0dad;
            border-radius: 50%;
            position: absolute;
            left: -33px;
            top: 20px;
        }

        .item p {
            margin: 5px 0;
        }

        .item b {
            color: #6a0dad;
        }

        .highlight {
            color: green;
            font-weight: bold;
        }

        .item:hover {
            transform: translateY(-3px);
            transition: 0.2s;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        }

        .nav {
            text-align: center;
            margin-top: 30px;
        }

        .nav a {
            text-decoration: none;
            padding: 10px 15px;
            background: #6a0dad;
            color: white;
            margin: 5px;
            border-radius: 5px;
            display: inline-block;
        }

        .nav a:hover {
            background: #4b0082;
        }
    </style>
</head>
<body>

<h2>Timeline Perjalanan Belajar Coding</h2>

<div class="timeline">
    <?php foreach ($timeline as $data) : ?>
        <div class="item">
            <p class="<?= highlightTahun($data['tahun']); ?>">
                <b><?= $data['tahun']; ?></b> - <?= $data['judul']; ?>
            </p>
            <p><?= $data['deskripsi']; ?></p>
        </div>
    <?php endforeach; ?>
</div>

<div class="nav">
    <a href="tgs1_mdl5.php">profil</a>
    <a href="tgs3_mdl5.php">blog</a>
</div>

</body>
</html>