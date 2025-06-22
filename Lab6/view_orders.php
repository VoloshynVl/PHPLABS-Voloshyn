<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "Orders";

// Підключення до БД
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка з'єднання: " . $conn->connect_error);
}

// Отримуємо дату фільтра (якщо є)
$order_date = $_GET['order_date'] ?? '';

// Підготовка запиту
if ($order_date) {
    $stmt = $conn->prepare("SELECT * FROM `OrderDetails` WHERE `order_date` = ?");
    $stmt->bind_param("s", $order_date);
} else {
    $stmt = $conn->prepare("SELECT * FROM `OrderDetails` ORDER BY `order_date` DESC");
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Перегляд замовлень</title>
</head>
<body>
  <h1>Замовлення</h1>

  <form method="get">
    <label>Дата замовлення:
      <input type="date" name="order_date" value="<?= htmlspecialchars($order_date) ?>">
    </label>
    <button type="submit">Фільтрувати</button>
    <a href="view_orders.php">Скинути</a>
  </form>

  <?php if ($result->num_rows === 0): ?>
    <p>Немає жодного замовлення у вибраному діапазоні.</p>
  <?php else: ?>
    <table border="1" cellpadding="5">
      <tr>
        <th>ID</th><th>Товар</th><th>К-сть</th><th>Ціна</th><th>Дата</th><th>Дія</th>
      </tr>
      <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $row['id'] ?></td>
          <td><?= htmlspecialchars($row['product_name']) ?></td>
          <td><?= $row['quantity'] ?></td>
          <td><?= number_format($row['price'], 2) ?></td>
          <td><?= $row['order_date'] ?></td>
          <td>
            <a href="delete_order.php?id=<?= $row['id'] ?>"
               onclick="return confirm('Видалити замовлення #<?= $row['id'] ?>?');">
               Видалити
            </a>
          </td>
        </tr>
      <?php endwhile; ?>
    </table>
  <?php endif; ?>

</body>
</html>
<?php
$stmt->close();
$conn->close();
?>
