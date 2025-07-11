<?php
$activePage = 'praktikum';
$pageTitle = 'Manajemen Praktikum';
include '../config.php';
include 'templates/header.php';

// Tambah
if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    mysqli_query($conn, "INSERT INTO praktikum (nama, deskripsi) VALUES ('$nama', '$deskripsi')");
    header("Location: praktikum_list.php");
    exit;
}

// Edit
if (isset($_POST['edit'])) {
    $id = intval($_POST['id']);
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    mysqli_query($conn, "UPDATE praktikum SET nama='$nama', deskripsi='$deskripsi' WHERE id=$id");
    header("Location: praktikum_list.php");
    exit;
}

// Hapus
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM praktikum WHERE id=$id");
    header("Location: praktikum_list.php");
    exit;
}

// Data
$praktikum = mysqli_query($conn, "SELECT * FROM praktikum");
$edit_data = null;
if (isset($_GET['edit_id'])) {
    $eid = intval($_GET['edit_id']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM praktikum WHERE id=$eid"));
}
?>

<h1 class="text-2xl font-bold mb-4">Kelola Praktikum</h1>
<div class="border p-4 mb-4">
    <form method="post">
        <input type="text" name="nama" placeholder="Nama Praktikum" value="<?= $edit_data['nama'] ?? '' ?>" class="border p-2 mb-2 block" required>
        <textarea name="deskripsi" placeholder="Deskripsi" class="border p-2 mb-2 block" required><?= $edit_data['deskripsi'] ?? '' ?></textarea>
        <?php if ($edit_data): ?>
            <input type="hidden" name="id" value="<?= $edit_data['id'] ?>">
            <button type="submit" name="edit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
            <a href="praktikum_list.php" class="ml-2 text-red-500">Batal</a>
        <?php else: ?>
            <button type="submit" name="add" class="bg-green-500 text-white px-4 py-2 rounded">Tambah</button>
        <?php endif; ?>
    </form>
</div>

<table class="border w-full">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Deskripsi</th>
        <th>Aksi</th>
    </tr>
    <?php while($p = mysqli_fetch_assoc($praktikum)): ?>
    <tr>
        <td><?= $p['id'] ?></td>
        <td><?= htmlspecialchars($p['nama']) ?></td>
        <td><?= htmlspecialchars($p['deskripsi']) ?></td>
        <td>
            <a href="praktikum_list.php?edit_id=<?= $p['id'] ?>" class="text-blue-500">Edit</a> |
            <a href="praktikum_list.php?delete=<?= $p['id'] ?>" onclick="return confirm('Hapus?')" class="text-red-500">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'templates/footer.php'; ?>
