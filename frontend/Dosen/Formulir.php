<?php
session_start();
include '../../backend/config_db.php';

// User login sebagai dosen
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
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Periksa apakah form dikirim
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $namaLengkap = $_POST['namaLengkap'];
    $tanggalPelanggaran = $_POST['tanggalPelanggaran'];
    $jenisPelanggaran = $_POST['jenisPelanggaran'];  // ID jenis pelanggaran yang dipilih
    $nidn = $dosen['NIDN']; // Gunakan NIDN yang diambil dari database
    $nim = $_POST['nim']; // Anggap ada input untuk NIM
    $tempatPelanggaran = $_POST['tempatPelanggaran'];

    // Cek surat jika ada, beri nilai null jika tidak ada
    $surat = isset($_POST['surat']) ? $_POST['surat'] : null;

    // Cek adminID di session, beri nilai null jika tidak ada
    $adminID = isset($_SESSION['adminID']) ? $_SESSION['adminID'] : null;

    $tugasID = isset($_POST['tugasID']) ? $_POST['tugasID'] : NULL;  // ID tugas jika relevan

    // Proses upload file
    $buktiFoto = null;
    if (isset($_FILES['buktiFoto']) && $_FILES['buktiFoto']['error'] == 0) {
        $targetDir = "C:/laragon/www/myWeb/PBL/upload/FilePelanggaran/"; // Path folder lokal untuk upload
        $buktiFoto = basename($_FILES['buktiFoto']['name']); // Ambil nama file
        $targetFile = $targetDir . $buktiFoto; // Gabungkan path dan nama file

        // Pastikan file berhasil dipindahkan ke folder target
        if (!move_uploaded_file($_FILES['buktiFoto']['tmp_name'], $targetFile)) {
            echo "Error uploading the file.";
            exit();
        }
    }


    // Proses tugas yang diberikan
    $tugas = null;
    if (isset($_POST['tugas'])) {
        $tugas = $_POST['tugas'];
    }

    try {
        // Insert langsung ke tabel Pelanggaran
        $query = "INSERT INTO Pelanggaran (
            NIM, NIDN, JenisID, TanggalPelanggaran, TempatPelanggaran, BuktiFoto, Surat, Status, AdminID, TugasID
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $stmt->execute([
            $nim,
            $nidn,
            $jenisPelanggaran,
            $tanggalPelanggaran,
            $tempatPelanggaran,
            $buktiFoto, // Simpan hanya nama file di database
            $surat,
            'Pending',
            $adminID,
            $tugasID
        ]);
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }

    if (isset($_GET['JenisID'])) {
        $JenisID = $_GET['JenisID'];
    
        try {
            $sql = "SELECT Tingkat, Poin FROM JenisPelanggaran WHERE JenisID = :JenisID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':JenisID', $JenisID, PDO::PARAM_INT);
            $stmt->execute();
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            echo json_encode($result);
        } catch (PDOException $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                            <a href="#" class="align-middle bg-white">
                                <img src="/myWeb/PBL/frontend/img/reading.svg" alt="" class="img-purple">
                                <span class="ms-1 d-none d-sm-inline purple-text"><strong>Formulir</strong></span>
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

            <form method="POST" enctype="multipart/form-data">
                <!-- Main Content -->
                <div class="col-12 offset-md-3 offset-xl-2 main-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="purple-text title-font"><strong>Form Unggahan Sanksi</strong></h1>
                        <div class="d-flex flex-column purple-text">
                            <h5><?php echo htmlspecialchars($dosen['Nama']); ?></h5>
                            <p>Dosen</p>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm content-placeholder">
                        <div class="card-header text-white purple-card-header">
                            <h5 class="mb-0 ">Bukti Melakukan Pelanggaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="buktiFoto">Bukti Foto</label>
                                        <input type="file" class="form-control-file" id="buktiFoto" name="buktiFoto" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namaLengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="namaLengkap" name="namaLengkap" placeholder="Samantha" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggalPelanggaran">Tanggal Pelanggaran & Tempat</label>
                                        <div class="input-group gap-2">
                                            <input type="date" name="tanggalPelanggaran" required>
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" name="tempatPelanggaran" placeholder="LSI 1" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="jenisPelanggaran">Jenis Pelanggaran</label>
                                        <select class="form-control" id="jenisPelanggaran" name="jenisPelanggaran" required>
                                            <option value="">Pilih Jenis Pelanggaran</option>
                                            <?php
                                            include '../../backend/config_db.php';

                                            try {
                                                // Query untuk mengambil data jenis pelanggaran
                                                $sql = "SELECT JenisID, NamaPelanggaran, Tingkat, Poin FROM JenisPelanggaran";
                                                $stmt = $conn->prepare($sql);
                                                $stmt->execute();
                                                $jenisPelanggaran = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                // Loop untuk menampilkan pilihan jenis pelanggaran
                                                foreach ($jenisPelanggaran as $jenis) {
                                                    echo "<option value='" . $jenis['JenisID'] . "' data-tingkat='" . $jenis['Tingkat'] . "' data-poin='" . $jenis['Poin'] . "'>" . $jenis['NamaPelanggaran'] . "</option>";
                                                }
                                            } catch (PDOException $e) {
                                                echo "Error: " . $e->getMessage();
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group d-flex gap-3">
                                        <div>
                                            <label for="poin">Poin</label>
                                            <input type="text" name="poin" id="poin" placeholder="6" class="form-control" readonly>
                                        </div>
                                        <div>
                                            <label for="tingkat">Tingkat</label>
                                            <input type="text" name="tingkat" id="tingkat" placeholder="II" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nim">NIM</label>
                                        <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM mahasiswa" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="tugas">Tugas Yang Diberikan</label>
                                <textarea class="form-control" id="tugas" name="tugas" rows="10" placeholder="Deskripsikan tugas yang diberikan..."></textarea>
                            </div>
                            <button type="submit" class="btn text-white purple-card-header">Kirim Bukti</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('jenisPelanggaran').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const poin = selectedOption.getAttribute('data-poin') || '';
            const tingkat = selectedOption.getAttribute('data-tingkat') || '';

            document.getElementById('poin').value = poin;
            document.getElementById('tingkat').value = tingkat;
        });
    </script>

</body>

</html>