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
