<?php
$activePage = 'modul';
$pageTitle = 'Manajemen Modul';
include '../config.php';
include 'templates/header.php';

// Tambah modul
if (isset($_POST['add'])) {
    $praktikum_id = intval($_POST['praktikum_id']);
    $judul = $_POST['judul'];
    $file = $_FILES['file_materi']['name'];

    // Pastikan folder uploads ada
    if (!is_dir("../uploads")) {
        mkdir("../uploads", 0755, true);
    }

    move_uploaded_file($_FILES['file_materi']['tmp_name'], "../uploads/".$file);
    mysqli_query($conn, "INSERT INTO modul (praktikum_id, judul, file_materi) VALUES ('$praktikum_id', '$judul', '$file')");
    header("Location: modul_list.php");
    exit;
}

// Edit modul
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $praktikum_id = intval($_POST['praktikum_id']);
    $judul = $_POST['judul'];

    // Cek apakah upload file baru
    if (!empty($_FILES['file_materi']['name'])) {
        $file = $_FILES['file_materi']['name'];
        if (!is_dir("../uploads")) {
            mkdir("../uploads", 0755, true);
        }
        move_uploaded_file($_FILES['file_materi']['tmp_name'], "../uploads/".$file);
        mysqli_query($conn, "UPDATE modul SET praktikum_id='$praktikum_id', judul='$judul', file_materi='$file' WHERE id=$id");
    } else {
        mysqli_query($conn, "UPDATE modul SET praktikum_id='$praktikum_id', judul='$judul' WHERE id=$id");
    }
    header("Location: modul_list.php");
    exit;
}

// Hapus modul
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM modul WHERE id=$id");
    header("Location: modul_list.php");
    exit;
}

// Data praktikum & modul
$praktikum = mysqli_query($conn, "SELECT * FROM praktikum");
$modul = mysqli_query($conn, "
    SELECT modul.*, praktikum.nama AS praktikum_nama 
    FROM modul 
    JOIN praktikum ON modul.praktikum_id = praktikum.id
");

// Cek apakah sedang edit
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $eid = intval($_GET['edit_id']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM modul WHERE id=$eid"));
}
?>

<h1 class="text-2xl font-bold mb-4">Manajemen Modul</h1>

<!-- Form tambah / edit -->
<div class="border p-4 mb-4">
    <h2 class="font-semibold mb-2"><?= $edit_data ? 'Edit Modul' : 'Tambah Modul' ?></h2>
    <form method="post" enctype="multipart/form-data">
        <select name="praktikum_id" class="border p-2 mb-2" required>
            <option value="">Pilih Praktikum</option>
            <?php while($p = mysqli_fetch_assoc($praktikum)): ?>
                <option value="<?= $p['id'] ?>" <?= ($edit_data && $edit_data['praktikum_id'] == $p['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($p['nama']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <input type="text" name="judul" placeholder="Judul Modul" value="<?= htmlspecialchars($edit_data['judul'] ?? '') ?>" class="border p-2 block mb-2" required>
        <input type="file" name="file_materi" class="block mb-2" <?= $edit_data ? '' : 'required' ?>>

        <?php if ($edit_data): ?>
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <button type="submit" name="edit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
            <a href="modul_list.php" class="ml-2 text-red-500">Batal</a>
        <?php else: ?>
            <button type="submit" name="add" class="bg-green-500 text-white px-4 py-2 rounded">Tambah</button>
        <?php endif; ?>
    </form>
</div>

<!-- Tabel modul -->
<table class="border w-full">
    <tr>
        <th>ID</th>
        <th>Praktikum</th>
        <th>Judul</th>
        <th>File</th>
        <th>Aksi</th>
    </tr>
    <?php mysqli_data_seek($modul, 0); while($row = mysqli_fetch_assoc($modul)): ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= htmlspecialchars($row['praktikum_nama']) ?></td>
        <td><?= htmlspecialchars($row['judul']) ?></td>
        <td>
            <?php if($row['file_materi']): ?>
                <a href="../uploads/<?= htmlspecialchars($row['file_materi']) ?>" class="text-blue-500">Download</a>
            <?php else: ?>
                <span class="text-gray-400">Belum ada file</span>
            <?php endif; ?>
        </td>
        <td>
            <a href="modul_list.php?edit_id=<?= $row['id'] ?>" class="text-blue-500">Edit</a> |
            <a href="modul_list.php?delete=<?= $row['id'] ?>" onclick="return confirm('Hapus?')" class="text-red-500">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'templates/footer.php'; ?>
