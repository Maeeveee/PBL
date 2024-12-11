<?php
session_start();
include '../../backend/config_db.php';

//user login sebagai dosen
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
    exit();
}

// hitung jumlah mahasiswa
$queryMahasiswa = "SELECT COUNT(*) AS total_mahasiswa FROM mahasiswa";
$stmtMahasiswa = $conn->prepare($queryMahasiswa);
$stmtMahasiswa->execute();
$totalMahasiswa = $stmtMahasiswa->fetch(PDO::FETCH_ASSOC)['total_mahasiswa'];

// hitung jumlah dosen
$queryDosen = "SELECT COUNT(*) AS total_dosen FROM dosen";
$stmtDosen = $conn->prepare($queryDosen);
$stmtDosen->execute();
$totalDosen = $stmtDosen->fetch(PDO::FETCH_ASSOC)['total_dosen'];

$sql = "EXEC GetTopMahasiswaPelanggar @TopN = :topN";
$stmt = $conn->prepare($sql);
$topN = 5;
$stmt->bindParam(':topN', $topN, PDO::PARAM_INT);
$stmt->execute();
$leaderboardData = $stmt->fetchAll(PDO::FETCH_ASSOC);

$username = $_SESSION['username'];

try {
    // Query untuk mendapatkan informasi dosen berdasarkan username
    $sql = "SELECT A.NIDN, A.Nama, A.Email, A.NoTelepon
            FROM Dosen A
            INNER JOIN Users U ON A.NIDN = U.NIDN
            WHERE U.Username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Ambil hasil query
    $dosen = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika data dosen tidak ditemukan
    if (!$dosen) {
        $dosen = ['Nama' => 'Data tidak tersedia', 'Email' => 'Data tidak tersedia', 'NoTelepon' => 'Data tidak tersedia'];
    }

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="/myWeb/PBL/frontend/style/style.css">
    <title>PolinemaTertib</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar-->
            <div class="sidebar">
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="/myWeb/PBL/frontend/img/logoPoltib.png" alt="Logo JTI" class="img-sidebar">
                        <h1 class="fs-5 ms-2 d-none d-sm-inline title-sidebar mid-pixel-hide">Polinema<br>Tertib</h1>
                    </div>

                    <!-- Menu Sidebar -->
                    <ul class="nav nav-pills flex-column mb-auto align-items-center align-items-sm-start">
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="#" class="align-middle bg-white">
                                <img src="/myWeb/PBL/frontend/img/home.svg" alt="Home Icon" class="img-purple">
                                <span class="ms-1 d-none d-sm-inline purple-text"><Strong>Beranda</Strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="Formulir.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/reading.svg" alt="" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>Formulir</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="PolinemaToday.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/news.svg" alt="" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>PolinemaToday</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="Pelanggaran.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/illegal.svg" alt="" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>Pelanggaran</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="Profile.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/user.svg" alt="" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>Profile</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="Notifikasi.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/activity.svg" alt="" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>Notifikasi</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="/myWeb/PBL/frontend/Login.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/logout.png" alt="" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>Logout</strong></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 offset-md-3 offset-xl-2 main-content">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="purple-text title-font"><strong>Beranda</strong></h1>
                    <div class="d-flex flex-column purple-text">
                    <h5><?php echo htmlspecialchars($dosen['Nama']); ?></h5>
                        <p>Dosen</p>
                    </div>
                </div>

                <!-- Tampil  Jumlah Dosen & Mahasiswa -->
                <div class="bg-white p-3 rounded content-placeholder">
                    <div class="d-flex justify-content-center gap-5">
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="/myWeb/PBL/frontend/img/reading.svg" alt="" class="img-purple-large">
                            <div class="d-flex flex-column ms-3">
                                <h4 class="mb-0 purple-text"><strong>Mahasiswa</strong></h4>
                                <h5 class="purple-text-stay"><?php echo $totalMahasiswa; ?></h5>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <img src="/myWeb/PBL/frontend/img/teacher.svg" alt="" class="img-purple-large">
                            <div class="d-flex flex-column ms-3">
                                <h4 class="mb-0 purple-text"><strong>Dosen</strong></h4>
                                <h5 class="purple-text-stay"><?php echo $totalDosen; ?></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leaderboard Pelanggar -->
                <div class="bg-white p-3 rounded purple-text-stay content-placeholder mt-3">
                    <h4 style="color: #483D8B;"><strong>Top 5 Pelanggar</strong></h4>
                    <?php foreach ($leaderboardData as $row): ?>
                        <div class="p-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-5">
                                <img src="/myWeb/PBL/frontend/img/roundProfile.png" alt="" class="img-sidebar">
                                <p><strong>
                                    Nama<br>
                                    <?php echo htmlspecialchars($row['Nama']); ?>
                                    </strong>
                                </p>
                            </div>
                                <p class="low-pixel-hide">
                                    NIM<br>
                                    <?php echo htmlspecialchars($row['NIM']); ?>
                                </p>
                            <div class="d-flex low-pixel-hide">
                                <p>
                                    Jumlah Pelanggaran<br>
                                    <?php echo htmlspecialchars($row['JumlahPelanggaran']); ?>
                                </p>
                            </div>
                            
                            <a href="formSanksi.php?nim=<?php echo urlencode($row['NIM']); ?>" class="btn" style="color: #483D8B;">Print</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>