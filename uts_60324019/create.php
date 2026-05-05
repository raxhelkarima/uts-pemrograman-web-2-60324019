<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori - UTS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php
    require_once 'config/database.php';
    
    $errors = [];
    $kode = '';
    $nama = '';
    $deskripsi = '';
    $status = 'Aktif';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // TODO: Ambil dan sanitasi data dari form
        $kode = htmlspecialchars(trim($_POST['kode_kategori'] ?? ''), ENT_QUOTES, 'UTF-8');
        $nama = htmlspecialchars(trim($_POST['nama_kategori'] ?? ''), ENT_QUOTES, 'UTF-8');
        $deskripsi = htmlspecialchars(trim($_POST['deskripsi'] ?? ''), ENT_QUOTES, 'UTF-8');
        $status = trim($_POST['status'] ?? 'Aktif');

        // TODO: Validasi kode kategori
        if (empty($kode)) {
            $errors[] = "Kode kategori wajib diisi.";
        } elseif (strlen($kode) < 4 || strlen($kode) > 10) {
            $errors[] = "Kode kategori harus 4-10 karakter.";
        } elseif (substr($kode, 0, 4) !== 'KAT-') {
            $errors[] = "Kode kategori harus diawali 'KAT-'.";
        }

        // TODO: Validasi nama kategori
        if (empty($nama)) {
            $errors[] = "Nama kategori wajib diisi.";
        } elseif (strlen($nama) < 3) {
            $errors[] = "Nama kategori minimal 3 karakter.";
        } elseif (strlen($nama) > 50) {
            $errors[] = "Nama kategori maksimal 50 karakter.";
        }

        // TODO: Validasi deskripsi
        if (!empty($deskripsi) && strlen($deskripsi) > 200) {
            $errors[] = "Deskripsi maksimal 200 karakter.";
        }

        // TODO: Cek duplikasi kode
        if (empty($errors)) {
            $cek = $conn->prepare("SELECT id_kategori FROM kategori WHERE kode_kategori = ?");
            $cek->bind_param("s", $kode);
            $cek->execute();
            $result = $cek->get_result();

            if ($result->num_rows > 0) {
                $errors[] = "Kode kategori sudah digunakan.";
            }
            $cek->close();
        }

        // TODO: Jika tidak ada error, insert data
        if (empty($errors)) {
            $stmt = $conn->prepare("INSERT INTO kategori (kode_kategori, nama_kategori, deskripsi, status) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $kode, $nama, $deskripsi, $status);

            if ($stmt->execute()) {
                // TODO: Redirect jika berhasil
                header("Location: index.php?success=Data kategori berhasil ditambahkan");
                exit;
            } else {
                $errors[] = "Gagal menambahkan data kategori.";
            }

            $stmt->close();
        }
    }
    ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Tambah Kategori Baru</h4>
                    </div>
                    <div class="card-body">
                        <!-- TODO: Tampilkan error jika ada -->
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <!-- TODO: Form fields -->
                            <div class="mb-3">
                                <label for="kode_kategori" class="form-label">Kode Kategori</label>
                                <input type="text" class="form-control" id="kode_kategori" name="kode_kategori" value="<?= htmlspecialchars($kode) ?>" placeholder="KAT-001" required>
                            </div>

                            <div class="mb-3">
                                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= htmlspecialchars($nama) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?= htmlspecialchars($deskripsi) ?></textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block">Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_aktif" value="Aktif" <?= $status == 'Aktif' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="status_aktif">Aktif</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="status_nonaktif" value="Nonaktif" <?= $status == 'Nonaktif' ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="status_nonaktif">Nonaktif</label>
                                </div>
                            </div>
                            
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>