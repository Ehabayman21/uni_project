<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $mysqli->prepare("SELECT id, password, full_name FROM users WHERE username=? OR email=? LIMIT 1");
    $stmt->bind_param('ss', $username, $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $hash, $full);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['full_name'] = $full;
            header('Location: courses.php');
            exit;
        } else {
            $error = "خطأ في اسم المستخدم أو كلمة السر";
        }
    } else {
        $error = "خطأ في اسم المستخدم أو كلمة السر";
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>تسجيل دخول</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow">
        <div class="card-body">
          <h4 class="card-title mb-4 text-center">تسجيل الدخول</h4>
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?=htmlspecialchars($error)?></div>
          <?php endif; ?>
          <form method="post">
            <div class="mb-3">
              <label class="form-label">اسم المستخدم أو البريد</label>
              <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">كلمة السر</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <div class="d-grid">
              <button class="btn btn-primary">دخول</button>
            </div>
          </form>
          <hr>
          <a href="register.php">مستخدم جديد؟ إنشاء حساب</a>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
