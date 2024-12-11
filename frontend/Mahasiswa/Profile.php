<?php
session_start();
include '../../backend/config_db.php';

// User login check (assuming 'username' in session refers to the student's NIM)
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
    exit();
}

$username = $_SESSION['username']; // NIM from session

// Query to get student information based on NIM
$query = "SELECT m.NIM, m.Nama, m.Email, m.NoTelepon, p.Prodi
          FROM Mahasiswa m
          INNER JOIN ProgramStudi p ON m.ProdiID = p.ProdiID
          WHERE m.NIM = :username"; // Assuming session stores NIM
$stmt = $conn->prepare($query);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();

// Fetch result
$mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

// If no student data found, use default placeholder data
if (!$mahasiswa) {
    $mahasiswa = [
        'Nama' => 'Data tidak tersedia', 
        'Email' => 'Data tidak tersedia', 
        'NoTelepon' => 'Data tidak tersedia', 
        'Prodi' => 'Data tidak tersedia'
    ];
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
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>Beranda</strong></span>
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
                            <a href="#" class="align-middle bg-white">
                                <img src="/myWeb/PBL/frontend/img/user.svg" alt="" class="img-purple">
                                <span class="ms-1 d-none d-sm-inline purple-text"><strong>Profile</strong></span>
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
                        <h5><?php echo htmlspecialchars($mahasiswa['Nama']); ?></h5>
                        <p><?php echo htmlspecialchars($mahasiswa['Prodi']); ?></p>
                    </div>
                </div>

                <!-- Profile Section -->
                <div class="p-3 bg-white rounded d-flex flex-column content-placeholder content-placeholder-mid">
                    <img src="/myWeb/PBL/frontend/img/roundProfile.png" alt="Profile Picture" class="profile-pict">
                    <div class="d-flex align-items-center">
                        <div class="p-3 purple-text-stay">
                            <h5><?php echo htmlspecialchars($mahasiswa['Nama']); ?></h5>
                            <p class="text-secondary">Mahasiswa</p>
                            
                        </div>
                    </div>
                    <div class="d-flex justify-content-between p-3">
                        <span><h5 class="text-secondary">NIM: </h5> <p class="purple-text"><!-- Dipanggil Disini ya guys -->tes</p></span>
                        <span><h5 class="text-secondary">Tanggal Lahir: </h5> <p class="purple-text"><!-- Dipanggil Disini ya guys -->tes</p></span>
                        <span><h5 class="text-secondary">Alamat: </h5> <p class="purple-text"><!-- Dipanggil Disini ya guys -->tes</p></span>
                        <span><h5 class="text-secondary">HP: </h5> <p class="purple-text"><?php echo htmlspecialchars($mahasiswa['NoTelepon']); ?></p></span>
                        <span><h5 class="text-secondary">Email: </h5> <p class="purple-text"><?php echo htmlspecialchars($mahasiswa['Email']); ?></p></span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>