<?php
require_once '../config/db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($username && $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$username, $email, $hash]);
            $message = "<div class='alert alert-success'>🎉 Đăng ký thành công! <a href='login.php'>Đăng nhập ngay</a></div>";
        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>⚠️ Tên đăng nhập hoặc email đã tồn tại!</div>";
        }
    } else {
        $message = "<div class='alert alert-warning'>⚠️ Vui lòng nhập đầy đủ thông tin!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Đăng ký</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="../assets/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="col-md-6 mx-auto">
        <div class="card p-4">
            <h3 class="text-center text-primary mb-3"><i class="fa-solid fa-user-plus"></i> Đăng ký tài khoản</h3>
            <?= $message ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-user"></i> Tên đăng nhập</label>
                    <input type="text" name="username" class="form-control rounded-pill" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-envelope"></i> Email</label>
                    <input type="email" name="email" class="form-control rounded-pill">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-lock"></i> Mật khẩu</label>
                    <input type="password" name="password" class="form-control rounded-pill" required>
                </div>
                <button type="submit" class="btn btn-custom w-100 rounded-pill"><i class="fa-solid fa-paper-plane"></i> Đăng ký</button>
            </form>
            <p class="text-center mt-3">💗 Đã có tài khoản? <a href="login.php" class="text-decoration-none">Đăng nhập</a></p>
        </div>
    </div>
</div>
</body>
</html>
