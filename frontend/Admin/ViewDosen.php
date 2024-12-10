<?php
session_start();
include '../../backend/config_db.php';

// Cek apakah user sudah login sebagai dosen
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
    exit();
}

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

    // Query untuk mendapatkan data pendidikan dosen
    $sqlPendidikan = "SELECT Universitas, TahunMasuk, TahunLulus FROM Pendidikan WHERE NIDN = :NIDN";
    $stmtPendidikan = $conn->prepare($sqlPendidikan);
    $stmtPendidikan->bindParam(':NIDN', $dosen['NIDN'], PDO::PARAM_STR);
    $stmtPendidikan->execute();
    $pendidikan = $stmtPendidikan->fetchAll(PDO::FETCH_ASSOC);

    // Query untuk mendapatkan data pengalaman dosen
    $sqlPengalaman = "SELECT Deskripsi FROM Pengalaman WHERE NIDN = :NIDN";
    $stmtPengalaman = $conn->prepare($sqlPengalaman);
    $stmtPengalaman->bindParam(':NIDN', $dosen['NIDN'], PDO::PARAM_STR);
    $stmtPengalaman->execute();
    $pengalaman = $stmtPengalaman->fetchAll(PDO::FETCH_ASSOC);
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

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="d-flex flex-column align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="/myWeb/PBL/frontend/img/logoPoltib.png" alt="Logo JTI" class="img-sidebar">
                        <h1 class="fs-5 ms-2 d-none d-sm-inline title-sidebar mid-pixel-hide">Polinema<br>Tertib</h1>
                    </div>

                    <!-- Menu Sidebar -->
                    <ul class="nav nav-pills flex-column mb-auto align-items-center align-items-sm-start">
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="Dashboard.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/home.svg" alt="Home Icon" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><Strong>Beranda</Strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="Mahasiswa.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/reading.svg" alt="" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>Mahasiswa</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="Dosen.php" class="align-middle bg-white">
                                <img src="/myWeb/PBL/frontend/img/teacher.svg" alt="" class="img-purple">
                                <span class="ms-1 d-none d-sm-inline purple-text"><strong>Dosen</strong></span>
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
                    <h1 class="purple-text title-font"><strong>Profile</strong></h1>
                    <div class="d-flex flex-column purple-text">
                        <h5><?php echo htmlspecialchars($dosen['Nama']); ?></h5>
                        <p>Dosen</p>
                    </div>
                </div>

                <!-- Profile -->
                <div class="p-3 bg-white rounded d-flex flex-column content-placeholder content-placeholder-mid">
                    <img src="/myWeb/PBL/frontend/img/roundProfile.png" alt="" class="profile-pict">
                    <div class=" d-flex align-items-center justify-content-between">
                        <div class="p-3 purple-text-stay">
                            <h5><Strong>Rizal Abrar</Strong></h5>
                            <p>Dosen</p>
                        </div>
                        <div>
                            <p class="purple-text">HP: <?php echo htmlspecialchars($dosen['NoTelepon']); ?></p>
                        </div>
                        <div>
                            <p class="purple-text">Email: <?php echo htmlspecialchars($dosen['Email']); ?></p>
                        </div>
                    </div>
                    <div class="p-3 purple-text-stay">
                        <h5><Strong>Pendidikan</Strong></h5>
                        <ul>
                            <?php foreach ($pendidikan as $pendidikanItem): ?>
                                <li><?php echo htmlspecialchars($pendidikanItem['Universitas']); ?>, <?php echo htmlspecialchars($pendidikanItem['TahunMasuk']); ?> - <?php echo htmlspecialchars($pendidikanItem['TahunLulus']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="p-3 purple-text-stay">
                        <h5><Strong>Pengalaman</Strong></h5>
                        <ul>
                            <?php foreach ($pengalaman as $pengalamanItem): ?>
                                <li><?php echo htmlspecialchars($pengalamanItem['Deskripsi']); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>