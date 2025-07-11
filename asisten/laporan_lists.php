<?php
$activePage = 'laporan';
$pageTitle = 'Laporan Masuk';
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

// Ambil semua laporan + join nama mahasiswa & judul modul
$laporan = mysqli_query($conn, "
    SELECT laporan.*, users.nama AS mahasiswa_nama, modul.judul AS modul_judul
    FROM laporan 
    JOIN users ON laporan.mahasiswa_id = users.id
    JOIN modul ON laporan.modul_id = modul.id
    ORDER BY laporan.created_at DESC
");
?>

<h1 class="text-2xl font-bold mb-4">Laporan Masuk</h1>

<table class="border w-full mb-4">
    <tr>
        <th>ID</th>
        <th>Mahasiswa</th>
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
        <td><?= htmlspecialchars($l['modul_judul']) ?></td>
        <td>
            <?php if($l['file_laporan']): ?>
                <a href="../uploads/<?= $l['file_laporan'] ?>" class="text-blue-500">Download</a>
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($l['nilai'] ?? '-') ?></td>
        <td><?= htmlspecialchars($l['feedback'] ?? '-') ?></td>
        <td>
            <!-- Tombol nilai (open modal / inline) -->
            <button onclick="document.getElementById('form-<?= $l['id'] ?>').classList.toggle('hidden')" class="text-green-500">Nilai</button>
        </td>
    </tr>
    <tr id="form-<?= $l['id'] ?>" class="hidden">
        <td colspan="7">
            <form method="post" class="flex items-center gap-2">
                <input type="hidden" name="id" value="<?= $l['id'] ?>">
                <input type="number" name="nilai" value="<?= htmlspecialchars($l['nilai'] ?? '') ?>" placeholder="Nilai" class="border p-1" required>
                <input type="text" name="feedback" value="<?= htmlspecialchars($l['feedback'] ?? '') ?>" placeholder="Feedback" class="border p-1">
                <button type="submit" name="update" class="bg-blue-500 text-white px-2 py-1 rounded">Update</button>
            </form>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'templates/footer.php'; ?>
