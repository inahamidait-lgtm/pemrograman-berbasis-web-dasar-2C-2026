<?php
include 'koneksi.php';

if(isset($_POST['register'])){

    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);

    // cek email
    $cek = $conn->prepare(
        "SELECT id FROM users WHERE email=?"
    );

    $cek->bind_param("s", $email);
    $cek->execute();

    $result = $cek->get_result();

    if($result->num_rows > 0){

        echo "<script>alert('Email sudah digunakan')</script>";

    } else {

        $stmt = $conn->prepare(
            "INSERT INTO users(nama,email,password,role)
             VALUES(?,?,?,?)"
        );

        $stmt->bind_param(
            "ssss",
            $nama,
            $email,
            $password,
            $role
        );

        if($stmt->execute()){

            echo "
            <script>
                alert('Registrasi berhasil');
                window.location='login.php';
            </script>
            ";

        } else {

            echo "<script>alert('Registrasi gagal')</script>";

        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-500 to-purple-500 min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl">

    <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">
        Register
    </h2>   

    <form method="POST">

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Nama
            </label>

            <input
                type="text"
                name="nama"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Email
            </label>

            <input
                type="email"
                name="email"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
        </div>

        <div class="mb-4">
            <label class="block mb-2 font-semibold">
                Password
            </label>

            <input
                type="password"
                name="password"
                minlength="6"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
        </div>

        <div class="mb-6">
            <label class="block mb-2 font-semibold">
                Role
            </label>

            <select
                name="role"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
                <option value="">-- Pilih Role --</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
        </div>

        <button
            type="submit"
            name="register"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition duration-300"
        >
            Register
        </button>

    </form>

    <p class="text-center mt-5 text-gray-600">
        Sudah punya akun?
        <a href="login.php" class="text-blue-600 font-semibold hover:underline">
            Login
        </a>
    </p>

</div>

</body>
</html>