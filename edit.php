<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
require_once '../config/db.php';

$id = $_GET['id'] ?? null;
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$task = $stmt->fetch();

if (!$task) {
    die("Không tìm thấy công việc!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $due_date = $_POST['due_date'] ?: null;
    $status = $_POST['status'];

    $stmt = $pdo->prepare("UPDATE tasks SET title=?, description=?, due_date=?, status=? WHERE id=? AND user_id=?");
    $stmt->execute([$title, $desc, $due_date, $status, $id, $_SESSION['user_id']]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Chỉnh sửa công việc</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="../assets/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <div class="col-md-6 mx-auto">
        <div class="card p-4">
            <h3 class="text-center text-primary mb-3">
                <i class="fa-solid fa-pen-to-square"></i> Chỉnh sửa công việc
            </h3>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-pen"></i> Tiêu đề</label>
                    <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" class="form-control rounded-pill" required>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-align-left"></i> Mô tả</label>
                    <textarea name="description" class="form-control rounded-4" rows="3"><?= htmlspecialchars($task['description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-calendar-days"></i> Ngày hết hạn</label>
                    <input type="date" name="due_date" value="<?= $task['due_date'] ?>" class="form-control rounded-pill">
                </div>
                <div class="mb-3">
                    <label class="form-label"><i class="fa-solid fa-circle-check"></i> Trạng thái</label>
                    <select name="status" class="form-select rounded-pill">
                        <option value="pending" <?= $task['status']=='pending'?'selected':'' ?>>⏳ Đang chờ</option>
                        <option value="in_progress" <?= $task['status']=='in_progress'?'selected':'' ?>>🚀 Đang làm</option>
                        <option value="completed" <?= $task['status']=='completed'?'selected':'' ?>>✅ Hoàn thành</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-custom w-100 rounded-pill">
                    <i class="fa-solid fa-floppy-disk"></i> Lưu thay đổi
                </button>
                <a href="index.php" class="btn btn-outline-se
