<?php
session_start();
require 'config.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}
$uid = $_SESSION['user_id'];
$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);
    $stmt = $mysqli->prepare("INSERT IGNORE INTO registrations (user_id, course_id) VALUES (?, ?)");
    $stmt->bind_param('ii', $uid, $course_id);
    if ($stmt->execute()) {
        $msg = "تم تسجيل المادة.";
    } else {
        $msg = "حدث خطأ في التسجيل.";
    }
    $stmt->close();
}

// جلب جميع المقررات
$courses = $mysqli->query("SELECT * FROM courses ORDER BY id");
$registered = $mysqli->query("SELECT course_id FROM registrations WHERE user_id = $uid");
$reg_arr = [];
while ($r = $registered->fetch_assoc()) $reg_arr[] = $r['course_id'];
?>
<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>تسجيل المواد</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-light bg-white shadow-sm">
  <div class="container">
    <span class="navbar-brand">مرحبا، <?=htmlspecialchars($_SESSION['full_name'] ?? '')?></span>
    <a href="logout.php" class="btn btn-outline-secondary btn-sm">خروج</a>
  </div>
</nav>

<div class="container py-4">
  <?php if ($msg): ?><div class="alert alert-success"><?=$msg?></div><?php endif; ?>
  <div class="card">
    <div class="card-body">
      <h5>قائمة المقررات</h5>
      <table class="table table-striped">
        <thead><tr><th>كود</th><th>اسم المادة</th><th>ساعات</th><th>حالة</th><th>تسجيل</th></tr></thead>
        <tbody>
        <?php while ($c = $courses->fetch_assoc()): ?>
          <tr>
            <td><?=htmlspecialchars($c['code'])?></td>
            <td><?=htmlspecialchars($c['title'])?></td>
            <td><?=htmlspecialchars($c['credits'])?></td>
            <td><?= in_array($c['id'],$reg_arr) ? '<span class="badge bg-success">مسجل</span>' : '<span class="badge bg-secondary">غير مسجل</span>' ?></td>
            <td>
              <?php if (!in_array($c['id'],$reg_arr)): ?>
                <form method="post" style="display:inline">
                  <input type="hidden" name="course_id" value="<?=$c['id']?>">
                  <button class="btn btn-sm btn-primary">سجل</button>
                </form>
              <?php else: ?>
                -
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
