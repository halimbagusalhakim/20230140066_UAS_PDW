<?php
$activePage = 'dashboard';
$pageTitle = 'Dashboard';
include '../config.php';
include 'templates/header.php';

// Query total modul
$r = mysqli_query($conn, "SELECT COUNT(*) as total FROM modul");
$total_modul = mysqli_fetch_assoc($r)['total'];

// Query total laporan masuk
$r = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan");
$total_laporan = mysqli_fetch_assoc($r)['total'];

// Query laporan belum dinilai
$r = mysqli_query($conn, "SELECT COUNT(*) as total FROM laporan WHERE nilai IS NULL");
$laporan_belum_dinilai = mysqli_fetch_assoc($r)['total'];
?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-gray-200 p-4 rounded flex items-center">
        <div class="text-3xl mr-4">📘</div>
        <div>
            <div class="text-gray-600">Total Modul Diajarkan</div>
            <div class="text-2xl font-bold"><?= $total_modul ?></div>
        </div>
    </div>
    <div class="bg-gray-200 p-4 rounded flex items-center">
        <div class="text-3xl mr-4">✅</div>
        <div>
            <div class="text-gray-600">Total Laporan Masuk</div>
            <div class="text-2xl font-bold"><?= $total_laporan ?></div>
        </div>
    </div>
    <div class="bg-gray-200 p-4 rounded flex items-center">
        <div class="text-3xl mr-4">⏰</div>
        <div>
            <div class="text-gray-600">Laporan Belum Dinilai</div>
            <div class="text-2xl font-bold"><?= $laporan_belum_dinilai ?></div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>
