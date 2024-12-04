<?php
session_start();
include '../backend/config_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validasi input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: login.php");
        exit();
    }

    try {
        // LANGKAH 1: Update Password di Database Menjadi Hash
        $stmt = $conn->query("SELECT Username, Password FROM Users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($users as $user) {
            // Cek apakah password sudah di-hash
            if (strlen($user['Password']) < 60) { // Panjang hash biasanya >=60 karakter
                $hashedPassword = password_hash($user['Password'], PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE Users SET Password = :password WHERE Username = :username");
                $updateStmt->execute([':password' => $hashedPassword, ':username' => $user['Username']]);
            }
        }

        // LANGKAH 2: Login dengan Validasi Hash
        $query = "SELECT * FROM Users WHERE Username = :username";
        $stmt = $conn->prepare($query);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Debugging: Output role yang diterima
        echo 'Role: ' . $user['Role']; // Menampilkan nilai role yang didapat

        // Cek keberadaan user dan verifikasi password
        if ($user && password_verify($password, $user['Password'])) {
            // Set session variables
            session_regenerate_id(true);
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role'];

            // Redirect berdasarkan role
            $redirects = [
                'Admin' => '../Admin/Dashboard.html',
                'Dosen' => '../Dosen/Dashboard.html',
                'Mahasiswa' => '../Mahasiswa/Dashboard.html'
            ];

            if (array_key_exists($user['Role'], $redirects)) {
                header("Location: " . $redirects[$user['Role']]);
                exit();
            } else {
                $_SESSION['error'] = "Role not recognized";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
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
                <?php 
                if (isset($_SESSION['error'])) {
                    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
                    unset($_SESSION['error']);
                }
                ?>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="text-center">
                        <img src="img/logoJti.svg" alt="" style="width: 70px; height: 70px;">
                    </div>
                    <input type="text" class="form-control m-2" name="username" id="username" placeholder="Username">
                    <input type="password" class="form-control m-2" name="password" id="password" placeholder="Password">
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary m-2">Masuk</button>
                    </div>
                </form>
            </div>
        </div>
</body>
</html>