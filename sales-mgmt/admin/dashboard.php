<?php
// sales-mgmt/admin/dashboard.php
require_once __DIR__ . '/config.php';
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Адмін-панель</title>
  <style>
    /* Загальні налаштування */
    body {
      margin: 0;
      padding: 0;
      font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f6f8;
      color: #333;
    }
    .container {
      max-width: 700px;
      margin: 3em auto;
      background: #fff;
      padding: 2em;
      border-radius: 8px;
      box-shadow: 0 4px 16px rgba(0,0,0,0.08);
    }
    h1 {
      margin: 0 0 1em;
      text-align: center;
      font-size: 2em;
      color: #222;
    }

    /* Навігація */
    nav {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 1em;
    }
    nav a {
      display: inline-block;
      padding: 0.75em 1.5em;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border-radius: 6px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      transition: background-color 0.3s, transform 0.2s;
      font-weight: 500;
    }
    nav a:hover {
      background-color: #0056b3;
      transform: translateY(-2px);
    }

    /* Підпис внизу */
    .note {
      margin-top: 2em;
      text-align: center;
      color: #666;
      font-size: 0.95em;
    }

    /* Адаптивність */
    @media (max-width: 480px) {
      .container { margin: 1.5em; padding: 1em; }
      nav a { flex: 1 1 100%; text-align: center; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Панель адміністратора</h1>
    <nav>
      <a href="add_order.php">Додати замовлення</a>
      <a href="sales_report.php">Звіт</a>
      <a href="logout.php">Вихід</a>
    </nav>
    <p class="note">Оберіть дію з меню вище, щоб керувати замовленнями та звітами.</p>
  </div>
</body>
</html>
