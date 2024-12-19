<?php
session_start();
include '../../backend/config_db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: ./login.php');
    exit();
}

$username = $_SESSION['username'];

// Query to get student information based on NIM or Username
$query = "SELECT m.NIM, m.Nama, m.Email, m.NoTelepon, p.Prodi
          FROM Mahasiswa m
          INNER JOIN ProgramStudi p ON m.ProdiID = p.ProdiID
          WHERE m.NIM = :username";
$stmt = $conn->prepare($query);
$stmt->bindParam(':username', $username, PDO::PARAM_STR);
$stmt->execute();

// Fetch result
$mahasiswa = $stmt->fetch(PDO::FETCH_ASSOC);

// If no student data found, use default placeholder data
if (!$mahasiswa) {
    $mahasiswa = ['Nama' => 'Data tidak tersedia', 'Email' => 'Data tidak tersedia', 'NoTelepon' => 'Data tidak tersedia', 'Prodi' => 'Data tidak tersedia'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and process form data
    $nim = $_POST['nim'] ?? '';
    $tanggalPelanggaran = $_POST['tanggalPelanggaran'] ?? '';
    
    // File upload handling
    $buktiFoto = '';
    if (isset($_FILES['buktiFoto']) && $_FILES['buktiFoto']['error'] == 0) {
        $uploadDir = '../../uploads/bukti_penyelesaian/';
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Generate unique filename
        $fileExtension = pathinfo($_FILES['buktiFoto']['name'], PATHINFO_EXTENSION);
        $buktiFoto = $uploadDir . uniqid() . '_' . $nim . '.' . $fileExtension;
        
        // Move uploaded file
        if (move_uploaded_file($_FILES['buktiFoto']['tmp_name'], $buktiFoto)) {
            // File uploaded successfully
            $buktiFoto = str_replace('../../', '', $buktiFoto); // Store relative path
        } else {
            // Handle upload error
            $error = "Gagal mengunggah file.";
        }
    }
    
    // Get AdminID (you might need to modify this based on your authentication system)
    try {
        $adminQuery = "SELECT TOP 1 AdminID FROM Admin";
        $adminStmt = $conn->prepare($adminQuery);
        $adminStmt->execute();
        $admin = $adminStmt->fetch(PDO::FETCH_ASSOC);
        $adminID = $admin ? $admin['AdminID'] : null;
    } catch(PDOException $e) {
        // Log or handle the error
        $error = "Gagal mengambil AdminID: " . $e->getMessage();
        $adminID = null;
    }
    
    // Prepare and execute insert query
    try {
        $insertQuery = "INSERT INTO Konfirmasi (BuktiPenyelesaian, TanggalPelaksanaan, NIM, AdminID) 
                        VALUES (:buktiFoto, :tanggalPelanggaran, :nim, :adminID)";
        $insertStmt = $conn->prepare($insertQuery);
        $insertStmt->bindParam(':buktiFoto', $buktiFoto, PDO::PARAM_STR);
        $insertStmt->bindParam(':tanggalPelanggaran', $tanggalPelanggaran, PDO::PARAM_STR);
        $insertStmt->bindParam(':nim', $nim, PDO::PARAM_STR);
        $insertStmt->bindParam(':adminID', $adminID, PDO::PARAM_INT);
        
        $insertStmt->execute();
        
        // Redirect with success message
        $_SESSION['message'] = "Bukti penyelesaian berhasil dikirim.";
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch(PDOException $e) {
        // Handle database error
        $error = "Gagal menyimpan data: " . $e->getMessage();
    }
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

            <!-- Main Content -->
            <div class="col-12 offset-md-3 offset-xl-2 main-content">
                <?php 
                // Display success or error messages
                if (isset($_SESSION['message'])) {
                    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']);
                }
                if (isset($error)) {
                    echo '<div class="alert alert-danger">' . $error . '</div>';
                }
                ?>

                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="purple-text title-font"><strong>Form Sanksi</strong></h1>
                    <div class="d-flex flex-column purple-text">
                        <h5><?php echo htmlspecialchars($mahasiswa['Nama']); ?></h5>
                        <p><?php echo htmlspecialchars($mahasiswa['Prodi']); ?></p>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm content-placeholder">
                    <div class="card-header text-white purple-card-header">
                        <h5 class="mb-0 ">Bukti Penyelesaian Sanksi</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="buktiFoto">Bukti Foto</label>
                                        <input type="file" name="buktiFoto" class="form-control-file" id="buktiFoto" accept="image/*" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggalPelanggaran">Tanggal Penyelesaian</label>
                                        <div class="input-group gap-2">
                                            <input type="date" name="tanggalPelanggaran" class="form-control" id="tanggalPelanggaran" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nim">NIM</label>
                                        <input type="text" name="nim" id="nim" placeholder="Masukkan NIM mahasiswa" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn text-white purple-card-header">Kirim</button>                           
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>