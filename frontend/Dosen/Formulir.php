<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style/style.css">
    <script src="script/script.js"></script>
    <title>PolinemaTertib</title>
</head>

<body style="background-color: #483D8B;">
    <div class="container-fluid">
        <div class="row flex-nowrap">

            <!-- Sidebar -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebarColor">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100 position-fixed">
                    <div class="d-flex align-items-center mb-3">
                        <img src="/myWeb/PBL/frontend/img/logoJti.svg" alt="Logo JTI" class="me-2" style="width: 60px; height: 60px;">
                        <h1 class="fs-4 text-white m-0 d-none d-sm-inline">Polinema<br>Tertib</h1>
                    </div>

                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="Dashboard.php" class="nav-link align-middle" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                            onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/home.svg" alt="Home Icon" class="nav-icon me-2"
                                style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><Strong>Beranda</Strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="#" class="nav-link align-middle bg-white">
                                <img src="/myWeb/PBL/frontend/img/teacher.svg" alt="" class="nav-icon me-2"
                                style="filter: invert(26%) sepia(10%) saturate(5129%) hue-rotate(215deg) brightness(91%) contrast(91%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline" style="color: #483D8B;"><strong>Formulir</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="PolinemaToday.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/news.svg" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>PolinemaToday</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="Pelanggaran.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/illegal.svg" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>Pelanggaran</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="Profile.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/user.svg" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>Profile</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="Notifikasi.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/activity.svg" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>Notifikasi</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="/myWeb/PBL/frontend/Login.php" class="nav-link align-middle" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                            onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/logout.png" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>Logout</strong></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div  class="col py-3 min-vh-100" style="background-color: #e9e6fd;">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 style="color: #483D8B"><strong>Form Sanksi</strong></h1>
                    <div class="d-flex flex-column" style="color: #483D8B;">
                        <h5>Nama Dosen</h5>
                        <p>Dosen</p>
                    </div>
                </div>

                <div class="card mb-4 shadow-sm" style="width: 1200px; margin: auto;">
                    <div class="card-header text-white" style="background-color: #483D8B;">
                        <h5 class="mb-0">Bukti Melakukan Pelanggaran</h5>
                    </div>
                    <div class=" card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="buktiFoto">Bukti Foto</label>
                                        <input type="file" class="form-control-file" id="buktiFoto" accept="image/*">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="namaLengkap">Nama Lengkap</label>
                                        <input type="text" class="form-control" id="namaLengkap" placeholder="Samantha">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="tanggalPelanggaran">Tanggal Pelanggaran & Tempat</label>
                                        <div class="input-group gap-2">
                                            <input type="text" class="form-control" id="tanggalPelanggaran" placeholder="24 November 2024">
                                            <div class="input-group-append">
                                                <input type="text" class="form-control" placeholder="LSI 1">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group"> <label for="jenisPelanggaran">Jenis Pelanggaran</label>
                                        <select class="form-control" id="jenisPelanggaran">
                                            <option value="">Pilih Jenis Pelanggaran</option>
                                            <option value="ringan">Pelanggaran Ringan</option>
                                            <option value="sedang">Pelanggaran Sedang</option>
                                            <option value="berat">Pelanggaran Berat</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" id="email" placeholder="masukkan email anda" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Telepon</label>
                                        <input type="text" name="telepon" id="telepon" placeholder="Masukkan nomor telepon anda" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="deskripsi">Deskripsi Pelanggaran</label>
                                <textarea class="form-control" id="deskripsi" rows="10" placeholder="Deskripsikan pelanggaran yang terjadi..."></textarea>
                            </div>
                            <button type="submit" class="btn text-white" style="background-color: #483D8B;">Kirim Bukti</button>
                        </div>
                </div>
             </div>

        </div>
    </div>
</body>

</html>