// admin/config.php
<?php
session_start();
if (empty($_SESSION['admin_id'])) {
  header('Location: login.php');
  exit;
}
// таймаут, оновлення last_activity…
require_once __DIR__ . '/../config.php';  // ось сюди — єдиний файл з підключенням до БД
