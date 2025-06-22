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
