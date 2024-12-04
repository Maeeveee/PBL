<?php
include 'config_db.php';
// Fungsi untuk mendapatkan informasi admin
function getAdminInfo($conn, $username) {
    $stmt = $conn->prepare("SELECT NamaAdmin AS nama FROM Admin WHERE UserID = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Fungsi untuk menghitung total mahasiswa
function getTotalMahasiswa($conn) {
    $query = "SELECT COUNT(*) as total FROM Mahasiswa";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Fungsi untuk menghitung total dosen
function getTotalDosen($conn) {
    $query = "SELECT COUNT(*) as total FROM Dosen";
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    return $row['total'];
}

// Fungsi untuk mendapatkan notifikasi terbaru
function getLatestNotifications($conn, $username, $limit = 4) {
    $stmt = $conn->prepare("
        SELECT Judul AS judul, Isi AS pesan, CURRENT_TIMESTAMP AS waktu 
        FROM Notifikasi 
        WHERE Username = ?
        ORDER BY NotifikasiID DESC 
        LIMIT ?
    ");
    $stmt->bind_param("si", $username, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Fungsi untuk mendapatkan top pelanggar
function getTopPelanggar($conn, $limit = 5) {
    $stmt = $conn->prepare("
        SELECT 
            m.NIM AS nim, 
            m.Nama AS nama, 
            m.ProdiID AS kelas, 
            MAX(jp.Tingkat) AS tingkat_pelanggaran,
            COUNT(p.PelanggaranID) AS jumlah_pelanggaran
        FROM Mahasiswa m
        JOIN Pelanggaran p ON m.NIM = p.NIM
        JOIN JenisPelanggaran jp ON p.JenisID = jp.JenisID
        GROUP BY m.NIM, m.Nama, m.ProdiID
        ORDER BY jumlah_pelanggaran DESC, tingkat_pelanggaran DESC
        LIMIT ?
    ");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}
?>