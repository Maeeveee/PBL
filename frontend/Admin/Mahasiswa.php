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

<body style="background-color: #483D8B;">
    <div class="container-fluid">
        <div class="row flex-nowrap">

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
                            <a href="#" class="align-middle bg-white">
                                <img src="/myWeb/PBL/frontend/img/reading.svg" alt="" class="img-purple">
                                <span class="ms-1 d-none d-sm-inline purple-text"><strong>Mahasiswa</strong></span>
                            </a>
                        </li>
                        <li class="nav-item d-flex align-items-center list-space">
                            <a href="Dosen.php" class="align-middle">
                                <img src="/myWeb/PBL/frontend/img/teacher.svg" alt="" class="img-white">
                                <span class="ms-1 d-none d-sm-inline white-text"><strong>Dosen</strong></span>
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
                    <h1 class="purple-text title-font"><strong>Mahasiswa</strong></h1>
                    <div class="d-flex flex-column purple-text">
                        <h5>Nama Admin</h5>
                        <p>Admin</p>
                    </div>
                </div>

                <!-- Form cari -->
                <div class="p-3 content-placeholder">
                    <input type="text" placeholder="Cari.." class=" form-control" style="width: 25%;">
                </div>

                <!-- Tampil Mahasiswa -->
                <div class="p-3 content-placeholder">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="purple-text-stay">Nama</th>
                                <th class="purple-text-stay">NIM</th>
                                <th class="purple-text">Tanggal Lahir</th>
                                <th class="purple-text">Nama Wali</th>
                                <th class="purple-text">Kota Asal</th>
                                <th class="purple-text">Kontak</th>
                                <th class="purple-text">Kelas</th>
                            </tr>
                        </thead>
                        <tbody id="table-body" style="line-height: 2.5;">
                            <script>
                                for (let index = 0; index < 15; index++) {
                                    let tableData = `<tr class="align-middle">
                                        <td>Rizal</td>
                                        <td>12345678</td>
                                        <td class="low-pixel-hide">01-01-2000</td>
                                        <td class="low-pixel-hide">King</td>
                                        <td class="low-pixel-hide">Surabaya</td>
                                        <td class="low-pixel-hide">08123456789</td>
                                        <td class="low-pixel-hide">TI-2F</td>
                                    </tr>`;
                                    document.getElementById("table-body").innerHTML += tableData;
                                }
                            </script>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>