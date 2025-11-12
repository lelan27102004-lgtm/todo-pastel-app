<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
require_once '../config/db.php';
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$tasks = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Danh sách công việc</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
<link href="../assets/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand"><i class="fa-solid fa-heart"></i> To-Do Pastel</a>
        <div class="d-flex">
            <span class="navbar-text text-white me-3">🌸 Xin chào, <strong><?= htmlspecialchars($_SESSION['username']) ?></strong></span>
            <a href="../auth/logout.php" class="btn btn-light btn-sm rounded-pill"><i class="fa-solid fa-right-from-bracket"></i> Đăng xuất</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-primary"><i class="fa-solid fa-list-check"></i> Danh sách công việc</h4>
            <a href="create.php" class="btn btn-custom rounded-pill"><i class="fa-solid fa-plus"></i> Thêm công việc</a>
        </div>
        <table class="table table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tiêu đề</th>
                    <th>Ngày hết hạn</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($tasks): foreach ($tasks as $i => $t): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= htmlspecialchars($t['title']) ?></td>
                        <td><?= $t['due_date'] ?: '<i>Chưa đặt</i>' ?></td>
                        <td>
                            <?php
                            $colors = [
                                'pending' => 'secondary',
                                'in_progress' => 'warning',
                                'completed' => 'success'
                            ];
                            ?>
                            <span class="badge bg-<?= $colors[$t['status']] ?>"><i class="fa-solid fa-circle"></i> <?= $t['status'] ?></span>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= $t['id'] ?>" class="btn btn-outline-primary btn-sm rounded-pill"><i class="fa-solid fa-pen"></i></a>
                            <a href="delete.php?id=<?= $t['id'] ?>" onclick="return confirm('Xóa công việc này?')" class="btn btn-outline-danger btn-sm rounded-pill"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="5" class="text-center text-muted">✨ Chưa có công việc nào ✨</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
