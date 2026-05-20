<?php
session_start();

if(!isset($_SESSION['id'])){
    header("Location: login.php");
    exit;
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

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">

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
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
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
                    minlength="6"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                >
            </div>

            <button 
                type="submit"
                name="login"
                class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg transition"
            >
                Login
            </button>

        </form>

    </div>

</body>
</html>