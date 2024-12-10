<?php
session_start();
include '../../backend/config_db.php';

// Check if user is logged in as dosen
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
    exit();
}

$username = $_SESSION['username'];

// Query to get student information based on NIM
$queryMahasiswa = "SELECT m.NIM, m.Nama, m.Email, m.NoTelepon, p.Prodi
                   FROM Mahasiswa m
                   INNER JOIN ProgramStudi p ON m.ProdiID = p.ProdiID
                   WHERE m.NIM = :nim"; // Assuming session stores NIM
$stmtMahasiswa = $conn->prepare($queryMahasiswa);
$stmtMahasiswa->bindParam(':nim', $username, PDO::PARAM_STR);
$stmtMahasiswa->execute();

// Fetch result
$mahasiswa = $stmtMahasiswa->fetch(PDO::FETCH_ASSOC);

// If no student data found, set default placeholder data
if (!$mahasiswa) {
    $mahasiswa = ['Nama' => 'Data tidak tersedia', 'Email' => 'Data tidak tersedia', 'NoTelepon' => 'Data tidak tersedia', 'Prodi' => 'Data tidak tersedia'];
}

// Query to get violation history for the logged-in student
$queryViolations = "SELECT p.PelanggaranID, jp.NamaPelanggaran, p.TanggalPelanggaran, p.TempatPelanggaran, p.DeskripsiPelanggaran
                    FROM Pelanggaran p
                    INNER JOIN JenisPelanggaran jp ON p.JenisID = jp.JenisID
                    WHERE p.NIM = :nim
                    ORDER BY p.TanggalPelanggaran DESC"; // Order by date
$stmtViolations = $conn->prepare($queryViolations);
$stmtViolations->bindParam(':nim', $username, PDO::PARAM_STR);
$stmtViolations->execute();

// Fetch results
$violations = $stmtViolations->fetchAll(PDO::FETCH_ASSOC);
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
                        <h5><?php echo $mahasiswa['Nama']; ?></h5>
                        <p><?php echo $mahasiswa['Prodi']; ?></p>
                    </div>
                </div>

                <!-- Kalender -->
                <div class="d-flex justify-content-center middle-gap">
                    <!-- Kalender -->
                    <div class="bg-white p-3 rounded content-placeholder">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="purple-text"><strong>Kalender</strong></h4>
                            <div class="d-flex align-items-center gap-3">
                                <h4 style="color: #483D8B;"><strong>December 2024</strong></h4>
                            </div>
                        </div>

                        <div class="container mt-5">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Sun</th>
                                                <th>Mon</th>
                                                <th>Tue</th>
                                                <th>Wed</th>
                                                <th>Thu</th>
                                                <th>Fri</th>
                                                <th>Sat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-secondary">31</td>
                                                <td>1</td>
                                                <td>2</td>
                                                <td>3</td>
                                                <td>4</td>
                                                <td>5</td>
                                                <td>6</td>
                                            </tr>
                                            <tr>
                                                <td>7</td>
                                                <td class="bg-primary text-white">8</td>
                                                <td>9</td>
                                                <td>10</td>
                                                <td>11</td>
                                                <td>12</td>
                                                <td>13</td>
                                            </tr>
                                            <tr>
                                                <td>14</td>
                                                <td>15</td>
                                                <td>16</td>
                                                <td class="bg-danger text-white">17</td>
                                                <td>18</td>
                                                <td>19</td>
                                                <td>20</td>
                                            </tr>
                                            <tr>
                                                <td>21</td>
                                                <td>22</td>
                                                <td>23</td>
                                                <td>24</td>
                                                <td>25</td>
                                                <td>26</td>
                                                <td class="bg-warning text-white">27</td>
                                            </tr>
                                            <tr>
                                                <td>28</td>
                                                <td>29</td>
                                                <td>30</td>
                                                <td class="text-secondary">1</td>
                                                <td class="text-secondary">2</td>
                                                <td class="text-secondary">3</td>
                                                <td class="text-secondary">4</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Leaderboard Pelanggar -->
                <div class="bg-white p-3 rounded purple-text-stay content-placeholder">
                    <h4 style="color: #483D8B;"><strong>Riwayat Pelanggaran</strong></h4>
                    <div id="leaderboard">
                        <?php if (count($violations) > 0): ?>
                            <?php foreach ($violations as $violation): ?>
                                <div class="p-2 d-flex justify-content-between align-items-center border-bottom">
                                    <div class="d-flex align-items-center">
                                        <?php
                                        // Gunakan null coalescing operator untuk menghindari nilai null
                                        $fotoPelanggaran = htmlspecialchars($violation['FotoPelanggaran'] ?? 'default.jpg'); // Gambar default jika null
                                        $namaPelanggaran = htmlspecialchars($violation['NamaPelanggaran'] ?? 'Unknown');
                                        $tanggalPelanggaran = htmlspecialchars($violation['TanggalPelanggaran'] ?? 'Unknown date');
                                        $tempatPelanggaran = htmlspecialchars($violation['TempatPelanggaran'] ?? 'Unknown place');

                                        // Path relatif untuk gambar
                                        $imagePath = "/myWeb/PBL/upload/FilePelanggaran/$fotoPelanggaran";

                                        // Periksa apakah file ada di server
                                        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                                        if (!file_exists($fullPath)) {
                                            $imagePath = "/myWeb/PBL/upload/FilePelanggaran/default.jpg"; // Gambar default
                                        }
                                        ?>
                                        <a href="<?php echo $imagePath; ?>" target="_blank">
                                            <img src="<?php echo $imagePath; ?>" alt="Bukti Foto" class="img-sidebar" style="width: 40px; height: 40px; cursor: pointer;">
                                        </a>
                                        <div class="ms-2">
                                            <p class="mb-0"><strong><?php echo $namaPelanggaran; ?></strong></p>
                                            <p class="mb-0 text-muted" style="font-size: 0.9em;"><?php echo $tanggalPelanggaran; ?></p>
                                            <p class="mb-0" style="font-size: 0.9em;"><?php echo $tempatPelanggaran; ?></p>
                                        </div>
                                    </div>
                                    <a href="Formulir.php?id=<?php echo htmlspecialchars($violation['PelanggaranID'] ?? ''); ?>" class="btn btn-link" style="color: #483D8B; text-decoration: none;">Print</a>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>Tidak ada riwayat pelanggaran.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>