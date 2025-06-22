# Лабораторна робота №7


**Тема:** Міні-проєкт: створення динамічного вебдодатка.
**Виконавець:** Волошин Владислав  
**Група:** KNms1-B23  
**Дата виконання:** 19.05.2025  
**Варіант:** 3

---

## Завдання 1



**Умова:**  
Створити таблиці MySQL для зберігання даних про товари, клієнтів та замовлення

```php
<?php


$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'sales-mgmt';  

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
if ($mysqli->connect_error) {
    die('Connection error: ' . $mysqli->connect_error);
}
$mysqli->set_charset('utf8mb4');


```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab7/sales-mgmt/config.php)


## Завдання 2


**Умова:**  
Реалізувати функціонал для додавання нових замовлень через панель адміністратора.

```php
<?php
// sales-mgmt/admin/add_order.php
require_once __DIR__ . '/config.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cust_name   = trim($_POST['customer_name']);
    $product_id  = (int) $_POST['product_id'];
    $quantity    = max(1, (int) $_POST['quantity']);
    $order_date  = $_POST['order_date'];

    // Додаємо клієнта
    $stmt = $mysqli->prepare("INSERT INTO customers (name) VALUES (?)");
    $stmt->bind_param('s', $cust_name);
    $stmt->execute();
    $customer_id = $stmt->insert_id;
    $stmt->close();

    // Додаємо замовлення
    $stmt = $mysqli->prepare("
        INSERT INTO orders (customer_id, product_id, quantity, order_date)
        VALUES (?, ?, ?, ?)
    ");
    $stmt->bind_param('iiis', $customer_id, $product_id, $quantity, $order_date);
    if ($stmt->execute()) {
        $msg = "Замовлення успішно додано.";
    } else {
        $msg = "Помилка: " . $stmt->error;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Додати замовлення</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 500px;
      margin: 2em auto;
      padding: 0 1em;
      background-color: #f4f6f8;
    }
    .nav {
      text-align: left;
      margin-bottom: 1em;
    }
    .nav a {
      display: inline-block;
      text-decoration: none;
      background: #6c757d;
      color: #fff;
      padding: 0.5em 1em;
      border-radius: 4px;
      transition: background 0.2s;
    }
    .nav a:hover {
      background: #5a6268;
    }
    form {
      background: #fff;
      padding: 1.5em;
      border-radius: 8px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      margin-bottom: 1em;
      color: #333;
    }
    label {
      display: block;
      margin-top: 5px;       /* піднімаємо підписи вниз на кілька пікселів */
      margin-bottom: 8px;
      font-weight: bold;
      color: #555;
    }
    input, select {
      width: 100%;
      padding: 0.5em;
      margin-top: 0.25em;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }
    button {
      display: block;
      width: 100%;
      padding: 0.75em;
      margin-top: 1em;
      background: #28a745;
      color: #fff;
      border: none;
      border-radius: 4px;
      font-size: 1em;
      cursor: pointer;
      transition: background 0.2s, transform 0.1s;
    }
    button:hover {
      background: #218838;
      transform: translateY(-1px);
    }
    .message {
      padding: 0.75em;
      background: #e9ffe9;
      border: 1px solid #b2d8b2;
      border-radius: 4px;
      margin-bottom: 1em;
      text-align: center;
      color: #155724;
    }
  </style>
</head>
<body>

  <!-- Кнопка повернення -->
  <div class="nav">
    <a href="dashboard.php">← Повернутися назад</a>
  </div>

  <h2>Додати нове замовлення</h2>

  <?php if ($msg): ?>
    <div class="message"><?php echo htmlspecialchars($msg); ?></div>
  <?php endif; ?>

  <form method="post">
    <label for="customer_name">Клієнт (введіть ім’я)</label>
    <input id="customer_name" type="text" name="customer_name" placeholder="Іван Іваненко" required>

    <label for="product_id">Товар</label>
    <select id="product_id" name="product_id" required>
      <option value="" disabled selected>Оберіть товар</option>
      <?php
      $res = $mysqli->query("SELECT id, name FROM products");
      while ($p = $res->fetch_assoc()):
      ?>
        <option value="<?php echo $p['id']; ?>">
          <?php echo htmlspecialchars($p['name']); ?>
        </option>
      <?php endwhile; ?>
    </select>

    <label for="quantity">Кількість</label>
    <input id="quantity" type="number" name="quantity" value="1" min="1" required>

    <label for="order_date">Дата замовлення</label>
    <input id="order_date" type="date" name="order_date" value="<?php echo date('Y-m-d'); ?>" required>

    <button type="submit">Додати</button>
  </form>
</body>
</html>
```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab7/sales-mgmt/admin/add_order.php)

**Результат:**

## [![Скріншот Завдання 2](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab7/Screenshots/3th_screen.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab7/Screenshots/3th_screen.png) 

## Завдання 3


**Умова:**  
Побудувати звіт про загальний обсяг продажів за обраний період.


```php
<?php
// sales_report.php — звіт про обсяг продажів та деталі замовлень
require_once __DIR__ . '/config.php';

$orders = [];
$total_sum = 0;
$from = $_GET['from'] ?? '';
$to   = $_GET['to'] ?? '';

// Видалення замовлення
if ($from && $to && isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    $mysqli->query("DELETE FROM orders WHERE id = $del_id");
    header("Location: sales_report.php?from={$from}&to={$to}");
    exit;
}

// Завантаження даних
if ($from && $to) {
    $sql = "
      SELECT o.id,
             o.order_date,
             c.name AS customer,
             p.name AS product,
             o.quantity,
             (o.quantity * p.price) AS sum
      FROM orders o
      JOIN customers c ON o.customer_id = c.id
      JOIN products p ON o.product_id = p.id
      WHERE o.order_date BETWEEN ? AND ?
      ORDER BY o.order_date
    ";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('ss', $from, $to);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $orders[] = $row;
        $total_sum += $row['sum'];
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="utf-8">
  <title>Звіт продажів</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 2em auto; background: #f4f6f8; padding: 0 1em; }
    .nav { margin-bottom: 1em; }
    .nav a {
      display: inline-block;
      text-decoration: none;
      background: #6c757d;
      color: #fff;
      padding: 0.5em 1em;
      border-radius: 4px;
      transition: background 0.2s;
    }
    .nav a:hover { background: #5a6268; }
    h2 { text-align: center; margin-bottom: 1em; }
    form { display: flex; justify-content: center; gap: 1em; margin-bottom: 1.5em; }
    label { display: flex; flex-direction: column; font-weight: bold; }
    input, button { padding: 0.5em; border: 1px solid #ccc; border-radius: 4px; }
    button { background: #007bff; color: #fff; cursor: pointer; }
    button:hover { background: #0069d9; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 1em; background: #fff; }
    th, td { border: 1px solid #ddd; padding: 0.75em; text-align: left; }
    th { background: #e9ecef; }
    tfoot td { font-weight: bold; }
    a.delete { color: #dc3545; text-decoration: none; }
    a.delete:hover { text-decoration: underline; }
  </style>
</head>
<body>

  <!-- Кнопка повернення -->
  <div class="nav">
    <a href="dashboard.php">← Повернутися назад</a>
  </div>

  <h2>Звіт: обсяг продажів</h2>

  <form method="get">
    <label>
      З:<br>
      <input type="date" name="from" required value="<?php echo htmlspecialchars($from); ?>">
    </label>
    <label>
      До:<br>
      <input type="date" name="to" required value="<?php echo htmlspecialchars($to); ?>">
    </label>
    <button type="submit">Показати</button>
  </form>

  <?php if (!empty($orders)): ?>
    <table>
      <thead>
        <tr>
          <th>Дата</th>
          <th>Клієнт</th>
          <th>Товар</th>
          <th>Кількість</th>
          <th>Сума, грн</th>
          <th>Дія</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $o): ?>
        <tr>
          <td><?php echo htmlspecialchars($o['order_date']); ?></td>
          <td><?php echo htmlspecialchars($o['customer']); ?></td>
          <td><?php echo htmlspecialchars($o['product']); ?></td>
          <td><?php echo (int)$o['quantity']; ?></td>
          <td><?php echo number_format($o['sum'], 2, '.', ' '); ?></td>
          <td>
            <a class="delete"
               href="?from=<?php echo urlencode($from); ?>&to=<?php echo urlencode($to); ?>&delete=<?php echo $o['id']; ?>"
               onclick="return confirm('Видалити це замовлення?');">
              Видалити
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan="4">Загальна сума:</td>
          <td><?php echo number_format($total_sum, 2, '.', ' '); ?> грн</td>
          <td></td>
        </tr>
      </tfoot>
    </table>
  <?php elseif ($from): ?>
    <p>За вказаний період замовлень не знайдено.</p>
  <?php endif; ?>

</body>
</html>

```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab7/sales-mgmt/admin/sales_report.php)

**Результат:**

[![Скріншот Завдання 3](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab7/Screenshots/4th_screen.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab7/Screenshots/4th_screen.png) 
