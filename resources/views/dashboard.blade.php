<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Moodle</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

<div class="bg-white shadow-md rounded-lg p-6 w-96 text-center">
    <h1 class="text-2xl font-bold mb-4">Selamat datang!</h1>

    <p class="mb-2">Halo, <strong>{{ $user['fullname'] ?? 'User' }}</strong></p>
    <p class="text-gray-600 text-sm mb-6">{{ $user['email'] ?? '' }}</p>

    <a href="{{ route('moodle.logout') }}" 
       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
       Logout
    </a>
</div>

</body>
</html>
