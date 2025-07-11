<?php
$activePage = 'my_courses';
$pageTitle = 'Praktikum Saya';
include '../config.php';
include 'templates/header_mahasiswa.php';

// Proses upload laporan
if (isset($_POST['upload'])) {
    $modul_id = intval($_POST['modul_id']);
    $file = $_FILES['file_laporan']['name'];

    // Pastikan folder uploads ada & aman
    if (!is_dir("../uploads")) {
        mkdir("../uploads", 0755, true);
    }

    // Pindahkan file laporan ke folder uploads
    move_uploaded_file($_FILES['file_laporan']['tmp_name'], "../uploads/".$file);

    mysqli_query($conn, "INSERT INTO laporan (modul_id, mahasiswa_id, file_laporan) VALUES ('$modul_id', '{$_SESSION['user_id']}', '$file')");
    header("Location: my_courses.php");
    exit;
}

// Ambil modul praktikum yang sudah diikuti mahasiswa
$modul = mysqli_query($conn, "
    SELECT modul.*, praktikum.nama as praktikum_nama 
    FROM modul 
    JOIN praktikum ON modul.praktikum_id=praktikum.id
    JOIN pendaftaran ON pendaftaran.praktikum_id=praktikum.id
    WHERE pendaftaran.mahasiswa_id={$_SESSION['user_id']}
");
?>

<h2 class="text-xl font-semibold mb-2">Modul & Materi dari Praktikum yang Kamu Ikuti</h2>
<table class="border w-full mb-4">
    <tr>
        <th>ID</th>
        <th>Praktikum</th>
        <th>Judul Modul</th>
        <th>File Materi</th>
        <th>Status / Kumpul Laporan</th>
    </tr>
    <?php while($m = mysqli_fetch_assoc($modul)): ?>
    <?php
        // Cek apakah sudah ada laporan yang dikumpulkan
        $laporan = mysqli_query($conn, "SELECT * FROM laporan WHERE modul_id={$m['id']} AND mahasiswa_id={$_SESSION['user_id']}");
        $laporan_data = mysqli_fetch_assoc($laporan);
    ?>
    <tr>
        <td><?= $m['id'] ?></td>
        <td><?= htmlspecialchars($m['praktikum_nama']) ?></td>
        <td><?= htmlspecialchars($m['judul']) ?></td>
        <td>
            <?php if($m['file_materi']): ?>
                <a href="../uploads/<?= htmlspecialchars($m['file_materi']) ?>" class="text-blue-500">Download</a>
            <?php else: ?>
                <span class="text-gray-400">Belum ada file</span>
            <?php endif; ?>
        </td>
        <td>
            <?php if ($laporan_data): ?>
                ✅ Sudah dikumpulkan
                <?php if ($laporan_data['nilai'] !== null): ?>
                    <div>Nilai: <?= htmlspecialchars($laporan_data['nilai']) ?></div>
                    <div>Feedback: <?= htmlspecialchars($laporan_data['feedback']) ?></div>
                <?php else: ?>
                    <div>Menunggu dinilai</div>
                <?php endif; ?>
                <div>
                    <a href="../uploads/<?= htmlspecialchars($laporan_data['file_laporan']) ?>" class="text-blue-500">Download Laporan</a>
                </div>
            <?php else: ?>
                <form method="post" enctype="multipart/form-data" class="flex gap-1">
                    <input type="hidden" name="modul_id" value="<?= $m['id'] ?>">
                    <input type="file" name="file_laporan" required class="border p-1">
                    <button type="submit" name="upload" class="bg-green-500 text-white px-2 rounded">Kumpul</button>
                </form>
            <?php endif; ?>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'templates/footer_mahasiswa.php'; ?>
