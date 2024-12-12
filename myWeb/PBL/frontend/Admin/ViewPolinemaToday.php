<?php
session_start();
include '../../backend/config_db.php';

//user login sebagai admin
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
    exit();
}

// Ambil parameter pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

try {
    // Query untuk menampilkan semua dosen jika tidak ada pencarian
    if (empty($search)) {
        $query = "SELECT * FROM Dosen";
        $stmt = $conn->prepare($query);
        $stmt->execute();
    } else {
        // Query dengan kondisi pencarian
        $query = "SELECT * FROM Dosen WHERE Nama LIKE :search OR Email LIKE :search";
        $stmt = $conn->prepare($query);
        $searchParam = "%$search%";
        $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
        $stmt->execute();
    }

    $dosenList = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Tangani error dengan baik
    echo "Error: " . $e->getMessage();
    exit();
}
$username = $_SESSION['username'];

try {
    // Query untuk mendapatkan informasi admin berdasarkan username
    $sql = "SELECT A.AdminID, A.NamaAdmin, A.EmailAdmin, A.NoTelepon
            FROM Admin A
            INNER JOIN Users U ON A.AdminID = U.AdminID
            WHERE U.Username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username, PDO::PARAM_STR);
    $stmt->execute();

    // Ambil hasil query
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika data admin tidak ditemukan
    if (!$admin) {
        $admin = ['NamaAdmin' => 'Data tidak tersedia', 'EmailAdmin' => 'Data tidak tersedia', 'NoTelepon' => 'Data tidak tersedia'];
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
                            <a href="Dosen.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/teacher.svg" alt="" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>Dosen</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="polinemaToday.php" class="align-middle bg-white">
                                <img src="/myWeb/PBL/frontend/img/news.svg" alt="" class="img-purple">
                                <span class="ms-1 d-none d-sm-inline purple-text"><strong>PolinemaToday</strong></span>
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
                    <h1 class="purple-text title-font"><strong>PolinemaToday</strong></h1>
                    <div class="d-flex flex-column purple-text">
                    <div class="d-flex flex-column purple-text">
                    <h5><?php echo htmlspecialchars($admin['NamaAdmin']); ?></h5>
                        <p>Admin</p>
                    </div>
                    </div>
                </div>

                <div class="p-3 bg-white rounded content-placeholder">
                    <div class="d-flex p-3 gap-3">
                        <img src="/myWeb/PBL/frontend/img/news.svg" alt="" class="profile-pict">
                        <div class="d-flex flex-column">
                            <h5 class="purple-text-stay">Judul Berita</h5>
                            <p class="text-secondary">tanggal</p>
                        </div>
                    </div>
                    <div class="d-flex p-3 gap-3 flex-column">
                        <h5 class="purple-text-stay">Berita</h5>
                        <p class="text-secondary">Isi berita</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>