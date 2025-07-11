<?php
$activePage = 'laporan';
$pageTitle = 'Penilaian Laporan';
include '../config.php';
include 'templates/header.php';

// Proses update nilai & feedback
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $nilai = intval($_POST['nilai']);
    $feedback = $_POST['feedback'];
    mysqli_query($conn, "UPDATE laporan SET nilai='$nilai', feedback='$feedback' WHERE id=$id");
    header("Location: laporan_list.php");
    exit;
}

// Ambil semua laporan + join ke modul, praktikum, dan mahasiswa
$laporan = mysqli_query($conn, "
    SELECT laporan.*, modul.judul as modul_judul, praktikum.nama as praktikum_nama, users.nama as mahasiswa_nama
    FROM laporan
    JOIN modul ON laporan.modul_id = modul.id
    JOIN praktikum ON modul.praktikum_id = praktikum.id
    JOIN users ON laporan.mahasiswa_id = users.id
");
?>

<h1 class="text-2xl font-bold mb-4">Penilaian Laporan</h1>
<table class="border w-full">
    <tr>
        <th>ID</th>
        <th>Mahasiswa</th>
        <th>Praktikum</th>
        <th>Modul</th>
        <th>File</th>
        <th>Nilai</th>
        <th>Feedback</th>
        <th>Aksi</th>
    </tr>
    <?php while($l = mysqli_fetch_assoc($laporan)): ?>
    <tr>
        <td><?= $l['id'] ?></td>
        <td><?= htmlspecialchars($l['mahasiswa_nama']) ?></td>
        <td><?= htmlspecialchars($l['praktikum_nama']) ?></td>
        <td><?= htmlspecialchars($l['modul_judul']) ?></td>
        <td>
            <?php if($l['file_laporan']): ?>
                <a href="../uploads/<?= $l['file_laporan'] ?>" class="text-blue-500">Download</a>
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($l['nilai'] ?? '-') ?></td>
        <td><?= htmlspecialchars($l['feedback'] ?? '-') ?></td>
        <td>
            <form method="post" class="flex gap-1">
                <input type="hidden" name="id" value="<?= $l['id'] ?>">
                <input type="number" name="nilai" value="<?= htmlspecialchars($l['nilai']) ?>" placeholder="Nilai" class="border p-1 w-16" required>
                <input type="text" name="feedback" value="<?= htmlspecialchars($l['feedback']) ?>" placeholder="Feedback" class="border p-1">
                <button type="submit" name="update" class="bg-yellow-500 text-white px-2 rounded">Update</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'templates/footer.php'; ?>
