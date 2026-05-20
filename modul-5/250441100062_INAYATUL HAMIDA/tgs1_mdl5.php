<?php
function tampilkanData($data) {
    echo "<table border='1' cellpadding='8' cellspacing='0'>";

    echo "<tr>
            <th colspan='2' style='background:#6a0dad; color:white; text-align:center;'>
                Hasil Input
            </th>
          </tr>";

    foreach ($data as $key => $value) {
        echo "<tr>
                <td><b>$key</b></td>
                <td>$value</td>
              </tr>";
    }

    echo "</table>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $framework = isset($_POST['framework']) ? trim($_POST['framework']) : '';
    $pengalaman = isset($_POST['pengalaman']) ? trim($_POST['pengalaman']) : '';
    $tools = isset($_POST['tools']) ? $_POST['tools'] : [];
    $minat = isset($_POST['minat']) ? $_POST['minat'] : '';
    $skill = isset($_POST['skill']) ? $_POST['skill'] : '';

if (
    $framework === '' ||
    $pengalaman === '' ||
    empty($tools) ||
    $minat === '' ||
    $skill === ''
) {
    echo "<p class='error'>Semua field wajib diisi!</p>";
}

        $frameworkArray = explode(",", $framework);

        $toolsGabung = implode(", ", $tools);

        $data = [
            "Framework/Tools Dikuasai" => implode(", ", $frameworkArray),
            "Tools Penunjang" => $toolsGabung,
            "Minat Bidang" => $minat,
            "Tingkat Skill" => $skill,
            "Pengalaman" => $pengalaman
        ];
        tampilkanData($data);

        if (count($frameworkArray) > 2) {
        echo "<p style='color:white; text-align:center;'><b>Skill Anda cukup luas di bidang development!</b></p>";
    }
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profil Interaktif Developer</title> 
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #6a0dad;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        color: #fbfbfc;
    }

    table {
        border-collapse: collapse;
        margin: 20px auto;
        width: 60%;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    table tr {
        border-bottom: 1px solid #eee;
    }

    table tr:last-child {
        border-bottom: none;
    }

    table td:first-child {
        width: 35%;
        background-color: #f1f5f9;
        font-weight: bold;
        color: #333;
    }

    table td:last-child {
        width: 65%;
        color: #070707;
    }

    table td {
        padding: 12px 15px;
    }

    table tr:nth-child(even) td:last-child {
        background-color: #fafafa;
    }

    table tr:hover td {
        background-color: #fafafa;
        transition: 0.2s;
    }

    form {
        width: 60%;
        margin: 20px auto;
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    input[type="text"],
    textarea,
    select {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #6a0dad;
        border-radius: 6px;
        box-sizing: border-box;
    }

    textarea {
        height: 80px;
    }

    button {
        background-color: #6a0dad;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }

    button:hover {
        background-color: #45a049;
    }

    nav {
        text-align: center;
        margin-top: 20px;
    }

    nav a {
        text-decoration: none;
        margin: 0 10px;
        padding: 8px 15px;
        background: #fafafa;
        color: #6a0dad;
        border-radius: 5px;
    }

    nav a:hover {
        background: #fffeff;
    }

    .error {
        color: red;
        text-align: center;
    }

    .success {
        color: green;
        text-align: center;
    }
</style>
</head>
<body>


<h2>Profil Interaktif Developer Pemula</h2>

<table border="1" cellpadding="8" cellspacing="0">
    <tr><td>Nama</td><td>Inayatul Hamida</td></tr>
    <tr><td>ID Developer</td><td>DEV001</td></tr>
    <tr><td>Kota/Tgl Lahir</td><td>Bojonegoro, 8 Oktober 2007</td></tr>
    <tr><td>Email</td><td>inahamida.it@gmail.com</td></tr>
    <tr><td>No. WhatsApp</td><td>08883936098</td></tr>
</table>

<br>

<form method="POST">
    
    <label>Framework/Tools (yang kamu kuasai):</label><br>
    <input type="text" name="framework"><br><br>

    <label>Pengalaman:</label><br>
    <textarea name="pengalaman"></textarea><br><br>

    <label>Tools Penunjang:</label><br>
    <input type="checkbox" name="tools[]" value="VS Code"> VS Code
    <input type="checkbox" name="tools[]" value="GitHub"> GitHub
    <input type="checkbox" name="tools[]" value="Figma"> Figma
    <input type="checkbox" name="tools[]" value="Postman"> Postman
    <br><br>

    <label>Minat Bidang:</label><br>
    <input type="radio" name="minat" value="Frontend"> Frontend
    <input type="radio" name="minat" value="Backend"> Backend
    <input type="radio" name="minat" value="Fullstack"> Fullstack
    <br><br>

    <label>Tingkat Skill:</label><br>
    <select name="skill">
        <option value="">-- Pilih --</option>
        <option value="Dasar">Dasar</option>
        <option value="Cukup">Cukup</option>
        <option value="Profesional">Profesional</option>
    </select>
    <br><br>

    <button type="submit">Kirim</button>
</form>

<nav>
<a href="tgs2_mdl5.php">timeline</a>
<a href="tgs3_mdl5.php">blog</a>
</nav>

</body>
</html>