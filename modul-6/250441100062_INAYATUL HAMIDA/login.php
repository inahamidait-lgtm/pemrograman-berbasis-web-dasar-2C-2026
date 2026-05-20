<?php
session_start();
include 'koneksi.php';

if(isset($_SESSION['id'])){

    if($_SESSION['role'] == 'admin'){
        header("Location: dashboard_admin.php");
    } else {
        header("Location: dashboard_user.php");
    }

    exit;
}

if(isset($_POST['login'])){

    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare(
        "SELECT * FROM users WHERE email=?"
    );

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $user = $result->fetch_assoc();

        // cek password
        if(password_verify($password, $user['password'])){

            $_SESSION['id'] = $user['id'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];

            // cek role
            if($user['role'] == 'admin'){

                header("Location: dashboard_admin.php");
                exit;

            } else {

                header("Location: dashboard_user.php");
                exit;

            }

        } else {

            echo "
            <script>
                alert('Password salah');
            </script>
            ";

        }

    } else {

        echo "
        <script>
            alert('Email tidak ditemukan');
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
    <title>Login</title>

        <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-500 to-purple-500 min-h-screen flex items-center justify-center">

<div class="bg-white w-full max-w-md p-8 rounded-2xl shadow-2xl">

    <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">
        Login
    </h2>

    <form method="POST">

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

        <div class="mb-6">
            <label class="block mb-2 font-semibold">
                Password
            </label>

            <input
                type="password"
                name="password"
                required
                class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
            >
        </div>

        <button
            type="submit"
            name="login"
            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-lg transition duration-300"
        >
            Login
        </button>

    </form>

    <p class="text-center mt-5 text-gray-600">
        Belum punya akun?
        <a href="register.php" class="text-blue-600 font-semibold hover:underline">
            Register
        </a>
    </p>

</div>

</body>
</html>