<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'asisten') {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Panel Asisten - <?= $pageTitle ?? 'Dashboard'; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-6 text-center border-b border-gray-700">
            <h3 class="text-xl font-bold">Panel Asisten</h3>
            <p class="text-sm text-gray-400 mt-1"><?= htmlspecialchars($_SESSION['nama']); ?></p>
        </div>
        <nav class="flex-grow">
            <ul class="space-y-2 p-4">
                <?php
                    $activeClass = 'bg-gray-900 text-white';
                    $inactiveClass = 'text-gray-300 hover:bg-gray-700 hover:text-white';
                ?>
                <li>
                    <a href="dashboard.php" class="<?= ($activePage == 'dashboard') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md">
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="praktikum_list.php" class="<?= ($activePage == 'praktikum') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md">
                        Manajemen Praktikum
                    </a>
                </li>
                <li>
                    <a href="modul_list.php" class="<?= ($activePage == 'modul') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md">
                        Manajemen Modul
                    </a>
                </li>
                <li>
                    <a href="users_list.php" class="<?= ($activePage == 'users') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md">
                        Manajemen Pengguna
                    </a>
                </li>
                <li>
                    <a href="laporan_list.php" class="<?= ($activePage == 'laporan') ? $activeClass : $inactiveClass; ?> flex items-center px-4 py-3 rounded-md">
                        Penilaian Laporan
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    <main class="flex-1 p-6 lg:p-10">
        <header class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800"><?= $pageTitle ?? ''; ?></h1>
            <a href="../logout.php" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg">Logout</a>
        </header>
