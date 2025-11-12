<?php
session_start();
require_once '../config/db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: ../tasks/index.php');
        exit;
    } else {
        $message = "<div class='alert alert-danger'>❌ Sai tên đăng nhập hoặc mật khẩu!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng nhập</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="../assets/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="col-md-6 mx-auto">
        <div class="card p-4">
            <h3 class="text-center text-primary mb-3"><i class="fa-solid fa-heart"></i> Đăng nhập</h3>
            <?= $message ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-user"></i> Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control rounded-pill" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-lock"></i> Mật khẩu</label>
                    <input type="password" name="password" class="form-control rounded-pill" required>
                </div>
                <button type="submit" class="btn btn-custom w-100 rounded-pill"><i class="fa-solid fa-right-to-bracket"></i> Đăng nhập</button>
            </form>
            <p class="text-center mt-3">💫 Chưa có tài khoản? <a href="register.php" class="text-decoration-none">Đăng ký ngay</a></p>
        </div>
    </div>
</div>
</body>
</html>
