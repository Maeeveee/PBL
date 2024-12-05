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
                            <a href="#" class="nav-link align-middle bg-white">
                                <img src="/myWeb/PBL/frontend/img/home.svg" alt="Home Icon" class="nav-icon me-2"
                                    style="filter: invert(26%) sepia(10%) saturate(5129%) hue-rotate(215deg) brightness(91%) contrast(91%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline"
                                    style="color: #483D8B;"><Strong>Beranda</Strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center mt-2 mb-2">
                            <a href="Formulir.php" class="nav-link align-middle"
                                onmouseover="this.style.backgroundColor='rgba(255,255,255,0.1)';"
                                onmouseout="this.style.backgroundColor='transparent';">
                                <img src="/myWeb/PBL/frontend/img/teacher.svg" alt="" class="nav-icon me-2"
                                    style="filter:invert(100%); width: 25px; height: 25px;">
                                <span class="ms-1 d-none d-sm-inline text-white"><strong>Formulir</strong></span>
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
            <div class="col py-3" style="background-color: #e9e6fd;">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 style="color: #483D8B"><strong>Beranda</strong></h1>
                    <div class="d-flex flex-column" style="color: #483D8B;">
                        <h5>Nama Mahasiswa</h5>
                        <p>Mahasiswa</p>
                    </div>
                </div>

                <!-- Kalender dan Pesan -->
                <div class="d-flex justify-content-center">
                    <!-- Kalender -->
                    <div class="bg-white p-3 rounded" style="width: 500px;margin: 20px;">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 style="color: #483D8B;"><strong>Kalender</strong></h4>
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

                    <!-- Pesan -->
                    <div class="bg-white p-3 rounded" style="width: 500px;margin: 20px;">
                        <h4 style="color: #483D8B;"><strong>Pesan</strong></h4>
                        <div id="pesan"></div>
                        <script>
                            for (let index = 0; index < 4; index++) {
                                let tampilPesan = ` <div class="p-3 d-flex justify-content-between">
                            <img src="/myWeb/PBL/frontend/img/roundProfile.png" alt="" style="width: 50px; height: 50px;">
                            <div class="d-flex flex-column" style="height: 50px;">
                                <p style="color: #483D8B;"><strong>Rizal Abrar Fahmi</strong><br>
                                    Masukkan pesan disini
                                </p>
                            </div>
                            <p style="color: #483D8B;">11:40</p>
                        </div>`;
                        document.getElementById("pesan").innerHTML += tampilPesan;
                            }
                        </script>
                    </div>
                </div>

                <!-- Tampilkan Riwayat Pelanggaran -->
                <div class="bg-white p-3 rounded" style="width: 1200px; margin: 0 auto; color: #483D8B;">
                    <h4 style="color: #483D8B;"><strong>Riwayat Pelanggaran</strong></h4>
                    <div id="Riwayat"></div>
                    <script>
                        for (let index = 0; index < 5; index++) {
                            let Riwayat = `
                            <div class="p-3 d-flex justify-content-between">
                        <div class="d-flex justify-content-center gap-5">
                            <img src="/myWeb/PBL/frontend/img/roundProfile.png" alt="" style="width: 50px; height: 50px;">
                            <p style="color: #483D8B;"><strong>Rizal Abrar Fahmi</strong></p>
                        </div>
                        <p>Tempat nim</p>
                        <div class="d-flex gap-2">
                            <div class="d-flex">
                                <p>
                                    kelas <br>
                                    TI 2F
                                </p>
                            </div>
                        </div>
                        <p><Strong>I</Strong></p>   
                        <a href="Formulir.php" class="btn" style="color: #483D8B;">Print</a>
                        </div>
                            `;
                            document.getElementById("Riwayat").innerHTML += Riwayat;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</body>

</html>