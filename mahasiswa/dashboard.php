<?php
$activePage = 'dashboard';
$pageTitle = 'Dashboard';
include '../config.php';
include 'templates/header_mahasiswa.php';

// Query data
$r = mysqli_query($conn, "SELECT COUNT(*) as total FROM praktikum");
$total_praktikum = mysqli_fetch_assoc($r)['total'];

$r = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan WHERE mahasiswa_id={$_SESSION['user_id']}");
$total_laporan = mysqli_fetch_assoc($r)['total'];
?>

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-gray-200 p-4 rounded">
        <div class="text-gray-600">Total Praktikum Tersedia</div>
        <div class="text-2xl font-bold"><?= $total_praktikum ?></div>
    </div>
    <div class="bg-gray-200 p-4 rounded">
        <div class="text-gray-600">Total Laporan Kamu</div>
        <div class="text-2xl font-bold"><?= $total_laporan ?></div>
    </div>
</div>

<?php include 'templates/footer_mahasiswa.php'; ?>
