<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';
    
    // TODO: Query data kategori
    $sql = "SELECT * FROM kategori ORDER BY id_kategori DESC";
    $stmt = $conn->prepare($sql); //ini merupakan prepared statement
    $stmt->execute();
    $result = $stmt->get_result();

    // TODO: Cek hasil query
    if (!$result) {
        die("Query gagal: " . $conn->error);
    }
    ?>
    
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Kategori Buku</h2>
            <a href="create.php" class="btn btn-primary">Tambah Kategori</a>
        </div>
        
        <!-- TODO: Tampilkan pesan sukses/error jika ada -->
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['success']) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['error']) ?>
            </div>
        <?php endif; ?>
        
        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th width="100">Kode</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>
                            <th width="100">Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // TODO: Loop data dan tampilkan
                        $no = 1;
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $no++ . "</td>";
                                echo "<td>" . htmlspecialchars($row['kode_kategori']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['nama_kategori']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['deskripsi']) . "</td>";
                                echo "<td>";
                                if ($row['status'] == 'Aktif') {
                                    echo '<span class="badge bg-success">Aktif</span>';
                                } else {
                                    echo '<span class="badge bg-danger">Nonaktif</span>';
                                }
                                echo "</td>";
                                echo "<td>";
                                echo '<a href="edit.php?id=' . $row['id_kategori'] . '" class="btn btn-warning btn-sm me-1">Edit</a>';
                                echo '<button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(' . $row['id_kategori'] . ')">Hapus</button>';
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center">Belum ada data kategori</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
    function confirmDelete(id) {
        if (confirm('Yakin ingin menghapus kategori ini?')) {
            window.location.href = 'delete.php?id=' + id;
        }
    }
    </script>
</body>
</html>