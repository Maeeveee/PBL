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

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">

            <!-- Sidebar di sebelah kiri -->
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sidebarColor">
                <div
                    class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100 position-fixed">
                    <div class="d-flex align-items-center mb-3">
                        <img src="/myWeb/PBL/frontend/img/logoJti.svg" alt="Logo JTI" class="me-2"
                            style="width: 60px; height: 60px;">
                        <h1 class="fs-4 text-white m-0 d-none d-sm-inline">Polinema<br>Tertib</h1>
                    </div>

                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                        id="menu">
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="/myWeb/PBL/frontend/Mahasiswa/Dashboard.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/home.svg" alt="Home Icon" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><Strong>Beranda</Strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="/myWeb/PBL/frontend/Mahasiswa/Formulir.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/teacher.svg" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>Formulir</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="/myWeb/PBL/frontend/Mahasiswa/PolinemaToday.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/news.svg" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>PolinemaToday</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="/myWeb/PBL/frontend/Mahasiswa/Pelanggaran.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/illegal.svg" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>Pelanggaran</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="#" class="nav-link align-middle bg-white">
                                <img src="/myWeb/PBL/frontend/img/user.svg" alt="" class="nav-icon me-2"
                                    style="filter: invert(26%) sepia(10%) saturate(5129%) hue-rotate(215deg) brightness(91%) contrast(91%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline"
                                    style="color: #483D8B;"><strong>Profile</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="/myWeb/PBL/frontend/Mahasiswa/Notifikasi.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/activity.svg" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>Notifikasi</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="/myWeb/PBL/frontend/Login.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
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
            <div class="col py-3 min-vh-100" style="background-color: #e9e6fd;">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 style="color: #483D8B"><strong>Profile</strong></h1>
                    <div class="d-flex flex-column" style="color: #483D8B;">
                        <h5>Nama Mahasiswa</h5>
                        <p>Mahasiswa</p>
                    </div>
                </div>

                <!-- Profile -->
                <div class="p-3 bg-white rounded d-flex flex-column" style="width: 1000px; margin: 0 auto;">
                    <img src="/myWeb/PBL/frontend/img/roundProfile.png" alt="" style="width:100px; height: 100px;">
                   <div class=" d-flex align-items-center justify-content-between">
                        <div class="p-3">
                            <h5 style="color: #483D8B;">Rizal Abrar</h5>
                            <p style="color: #483D8B;">Mahasiswa</p>
                        </div>
                        <div>
                            <p style="color: #483D8B;">HP: 08123456789</p>
                        </div>
                        <div>
                            <p style="color: #483D8B;">Email: 7AqgB@example.com</p>
                        </div>
                   </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>