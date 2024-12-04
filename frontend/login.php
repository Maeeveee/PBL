<?php
session_start();
include '../backend/config_db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $role = strtolower($_POST['role']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Validasi input
    if (empty($username) || empty($password) || empty($role)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: login.php");
        exit();
    }

    // Validasi role
    $allowed_roles = ['admin', 'dosen', 'mahasiswa'];
    if (!in_array($role, $allowed_roles)) {
        $_SESSION['error'] = "Invalid role";
        header("Location: login.php");
        exit();
    }
    
    try {
        // Query login berdasarkan role
        $queries = [
            'admin' => "SELECT * FROM Admin WHERE Nama = :username",
            'dosen' => "SELECT * FROM Dosen WHERE NIP = :username",
            'mahasiswa' => "SELECT * FROM Mahasiswa WHERE NIM = :username"
        ];

        $stmt = $conn->prepare($queries[$role]);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["Password" . ucfirst($role)])) {
            // Set session variables
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user[$role . 'ID'];
            $_SESSION['role'] = $role;
            $_SESSION['nama'] = $user['Nama'];
            
            // Redirect ke dashboard
            $redirects = [
                'admin' => '../Admin/Dashboard.html',
                'dosen' => '../Dosen/Dashboard.html',
                'mahasiswa' => '../Mahasiswa/Dashboard.html'
            ];
            header("Location: " . $redirects[$role]);
            exit();
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