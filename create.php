<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
require_once '../config/db.php';

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $due_date = $_POST['due_date'] ?: null;

    if ($title) {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $desc, $due_date]);
        header('Location: index.php');
        exit;
    } else {
        $message = "<div class='alert alert-warning'>⚠️ Vui lòng nhập tiêu đề công việc!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thêm công việc</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="../assets/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="col-md-6 mx-auto">
        <div class="card p-4">
            <h3 class="text-center text-primary mb-3">
                <i class="fa-solid fa-clipboard-list"></i> Thêm công việc mới
            </h3>
            <?= $message ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-pen"></i> Tiêu đề</label>
                    <input type="text" name="title" class="form-control rounded-pill" placeholder="Nhập tiêu đề..." required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-align-left"></i> Mô tả</label>
                    <textarea name="description" class="form-control rounded-4" rows="3" placeholder="Ghi chú công việc..."></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-calendar-days"></i> Ngày hết hạn</label>
                    <input type="date" name="due_date" class="form-control rounded-pill">
                </div>
                <button type="submit" class="btn btn-custom w-100 rounded-pill">
                    <i class="fa-solid fa-plus"></i> Thêm công việc
                </button>
                <a href="index.php" class="btn btn-outline-secondary w-100 rounded-pill mt-2">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại
                </a>
            </form>
        </div>
    </div>
</div>
</body>
</html>
