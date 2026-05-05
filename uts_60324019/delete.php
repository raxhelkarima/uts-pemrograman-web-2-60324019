<?php
require_once 'config/database.php';
 
// TODO: Validasi ID dari GET
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php?error=ID tidak valid");
    exit;
}
 
// TODO: Cek keberadaan data
$cek = $conn->prepare("SELECT id_kategori FROM kategori WHERE id_kategori = ?");
$cek->bind_param("i", $id);
$cek->execute();
$result = $cek->get_result();

if ($result->num_rows == 0) {
    header("Location: index.php?error=Data tidak ditemukan");
    exit;
}
$cek->close();
 
// TODO: Delete data
$stmt = $conn->prepare("DELETE FROM kategori WHERE id_kategori = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    $stmt->close();
    // TODO: Redirect dengan pesan
    header("Location: index.php?success=Data berhasil dihapus");
    exit;
} else {
    $stmt->close();
    // TODO: Redirect dengan pesan
    header("Location: index.php?error=Gagal menghapus data");
    exit;
}
?>