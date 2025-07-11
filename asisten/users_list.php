<?php
$activePage = 'users';
$pageTitle = 'Manajemen Pengguna';
include '../config.php';
include 'templates/header.php';

// Tambah user
if (isset($_POST['add'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Jalankan query & cek jika ada error
    $result = mysqli_query($conn, "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password', '$role')");
    if (!$result) {
        die('Query Error: ' . mysqli_error($conn));
    }

    header("Location: users_list.php");
    exit;
}

// Hapus user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $result = mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    if (!$result) {
        die('Query Error: ' . mysqli_error($conn));
    }

    header("Location: users_list.php");
    exit;
}

// Ambil data user
$users = mysqli_query($conn, "SELECT * FROM users");
if (!$users) {
    die('Query Error: ' . mysqli_error($conn));
}
?>

<h1 class="text-2xl font-bold mb-4">Kelola Pengguna</h1>
<div class="border p-4 mb-4">
    <form method="post">
        <input type="text" name="nama" placeholder="Nama" class="border p-2 mb-2 block" required>
        <input type="email" name="email" placeholder="Email" class="border p-2 mb-2 block" required>
        <input type="password" name="password" placeholder="Password" class="border p-2 mb-2 block" required>
        <select name="role" class="border p-2 mb-2 block" required>
            <option value="">Pilih Role</option>
            <option value="asisten">Asisten</option>
            <option value="mahasiswa">Mahasiswa</option>
        </select>
        <button type="submit" name="add" class="bg-green-500 text-white px-4 py-2 rounded">Tambah</button>
    </form>
</div>

<table class="border w-full">
    <tr>
        <th>ID</th>
        <th>Nama</th>
        <th>Email</th>
        <th>Role</th>
        <th>Aksi</th>
    </tr>
    <?php while($u = mysqli_fetch_assoc($users)): ?>
    <tr>
        <td><?= htmlspecialchars($u['id']) ?></td>
        <td><?= htmlspecialchars($u['nama']) ?></td>
        <td><?= htmlspecialchars($u['email']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
        <td>
            <a href="users_list.php?delete=<?= $u['id'] ?>" onclick="return confirm('Hapus?')" class="text-red-500">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

<?php include 'templates/footer.php'; ?>
