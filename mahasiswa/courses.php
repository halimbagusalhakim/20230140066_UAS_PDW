<?php
$activePage = 'courses';
$pageTitle = 'Cari Praktikum';
include '../config.php';
include 'templates/header_mahasiswa.php';

// Proses daftar praktikum
if (isset($_GET['daftar'])) {
    $praktikum_id = intval($_GET['daftar']);
    mysqli_query($conn, "INSERT IGNORE INTO pendaftaran (mahasiswa_id, praktikum_id) VALUES ('{$_SESSION['user_id']}', '$praktikum_id')");
    header("Location: courses.php");
    exit;
}

// Ambil semua praktikum
$praktikum = mysqli_query($conn, "SELECT * FROM praktikum");

// Ambil ID praktikum yang sudah diikuti mahasiswa
$pendaftaran = mysqli_query($conn, "SELECT praktikum_id FROM pendaftaran WHERE mahasiswa_id={$_SESSION['user_id']}");
$praktikum_terdaftar = [];
while($d = mysqli_fetch_assoc($pendaftaran)) {
    $praktikum_terdaftar[] = $d['praktikum_id'];
}
?>

<h2 class="text-xl font-semibold mb-2">Daftar Praktikum</h2>
<table class="border w-full mb-4">
    <tr>
        <th>ID</th>
        <th>Nama Praktikum</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>
    <?php while($p = mysqli_fetch_assoc($praktikum)): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['nama']) ?></td>
        <td><?= htmlspecialchars($p['deskripsi']) ?></td>
        <td>
            <?php if (in_array($p['id'], $praktikum_terdaftar)): ?>
                ✅ Sudah Terdaftar
            <?php else: ?>
                <a href="courses.php?daftar=<?= $p['id'] ?>" class="bg-green-500 text-white px-2 py-1 rounded">Daftar</a>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'templates/footer_mahasiswa.php'; ?>
