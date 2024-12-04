<?php
session_start();
include '../backend/config_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Validasi input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username dan password harus diisi";
        header("Location: login.php");
        exit();
    }

    try {
        // Array untuk menyimpan query pencarian role
        $roleQueries = [
            'Admin' => "SELECT 'admin' AS role, AdminID AS user_id, * FROM Admin WHERE Nama = :username",
            'Dosen' => "SELECT 'dosen' AS role, DosenID AS user_id, * FROM Dosen WHERE NIP = :username",
            'Mahasiswa' => "SELECT 'mahasiswa' AS role, MahasiswaID AS user_id, * FROM Mahasiswa WHERE NIM = :username"
        ];

        $user = null;
        $detectedRole = null;

        // Coba temukan user di setiap tabel
        foreach ($roleQueries as $tableName => $query) {
            $stmt = $conn->prepare($query);
            $stmt->execute([':username' => $username]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $user = $result;
                $detectedRole = $result['role'];
                break;
            }
        }

        // Periksa apakah user ditemukan dan password cocok
        if ($user) {
            // Sesuaikan kolom password berdasarkan role
            $passwordColumn = 'Password' . ucfirst($detectedRole);
            
            if ($password === $user[$passwordColumn]) {
                // Set session
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['role'] = $detectedRole;
                $_SESSION['nama'] = $user['Nama'];
                
                // Redirect berdasarkan role
                switch ($detectedRole) {
                    case 'admin':
                        $redirect = '../Admin/Dashboard.html';
                        break;
                    case 'dosen':
                        $redirect = '../Dosen/Dashboard.html';
                        break;
                    case 'mahasiswa':
                        $redirect = '../Mahasiswa/Dashboard.html';
                        break;
                }

                header("Location: " . $redirect);
                exit();
            }
        }

        // Jika user tidak ditemukan atau password salah
        $_SESSION['error'] = "Username atau password salah";
        header("Location: login.php");
        exit();

    } catch(PDOException $e) {
        $_SESSION['error'] = "Kesalahan basis data: " . $e->getMessage();
        header("Location: login.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
        <div class="container-fluid vh-100 d-flex flex-column align-items-center justify-content-center" style="background-color: #483D8B;">
            <h1 class="text-white">Polinema Tertib</h1>
            <div class="p-4 rounded" style="background-color: #e9e6fd; max-width: 400px; width: 100%;">
                <form action="index.html" method="post">
                    <div class="text-center">
                        <img src="img/logoJti.svg" alt="" style="width: 70px; height: 70px;">
                    </div>
                    <input type="text" class="form-control m-2" name="username" id="username" placeholder="Username">
                    <input type="password" class="form-control m-2" name="password" id="password" placeholder="Password">
                    <div class="text-center">
                        <button href="index.html" type="submit" class="btn btn-primary m-2">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
</body>
</html>