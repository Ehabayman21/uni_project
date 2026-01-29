<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $password = $_POST['password'];

    // تحقق بسيط
    if (strlen($password) < 6) $error = "كلمة السر لازم تكون 6 حروف على الاقل";

    if (!isset($error)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $mysqli->prepare("INSERT INTO users (username,email,password,full_name) VALUES (?,?,?,?)");
        $stmt->bind_param('ssss', $username, $email, $hash, $full_name);
        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        } else {
            $error = "حدث خطأ: ربما اسم المستخدم أو الايميل موجود";
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>انشاء حساب</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow">
        <div class="card-body">
          <h4 class="card-title mb-4 text-center">إنشاء حساب جديد</h4>
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">الاسم الكامل</label>
              <input type="text" name="full_name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">اسم المستخدم</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">البريد الإلكتروني</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">كلمة السر</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid">
              <button class="btn btn-success">إنشاء الحساب</button>
            </div>
          </form>
          <hr>
          <a href="index.php">للمستخدمين المسجلين تسجيل دخول</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
