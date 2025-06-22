<?php
// sales-mgmt/admin/login.php
session_start();
require_once __DIR__ . '/../config.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username']);
    $p = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, password FROM admins WHERE username = ?");
    $stmt->bind_param('s', $u);
    $stmt->execute();
    $stmt->bind_result($id, $hash);
    if ($stmt->fetch() && password_verify($p, $hash)) {
        session_regenerate_id(true);
        $_SESSION['admin_id']      = $id;
        $_SESSION['last_activity'] = time();
        header('Location: dashboard.php');
        exit;
    } else {
        $msg = 'Невірний логін або пароль.';
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="uk">
<head><meta charset="utf-8"><title>Вхід в Адмін-панель</title>
<style>
  body{font-family:Arial,sans-serif;max-width:360px;margin:5em auto;}
  form{background:#f0f0f0;padding:2em;border-radius:6px;}
  label{display:block;margin-bottom:1em;font-weight:bold;}
  input{width:100%;padding:.5em;margin-top:.25em;border:1px solid #ccc;border-radius:4px;}
  button{width:100%;padding:.75em;background:#007bff;color:#fff;border:none;border-radius:4px;cursor:pointer;}
  .error{color:#b00;margin-bottom:1em;}
</style>
</head>
<body>
  <h2>Адмін-панель — вхід</h2>
  <?php if($msg):?><p class="error"><?php echo htmlspecialchars($msg);?></p><?php endif;?>
  <form method="post">
    <label>Логін
      <input type="text" name="username" required placeholder="admin">
    </label>
    <label>Пароль
      <input type="password" name="password" required placeholder="••••••">
    </label>
    <button type="submit">Увійти</button>
  </form>
</body>
</html>
