<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "Orders";

// 1) Підключення до MySQL (без вибору БД)
$conn = new mysqli($servername, $username, $password);
if ($conn->connect_error) {
    die("Помилка з'єднання: " . $conn->connect_error);
}

// 2) Створення БД Orders
$sql = "CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($sql) !== TRUE) {
    die("Не вдалося створити БД: " . $conn->error);
}

// 3) Вибір БД
$conn->select_db($dbname);

// 4) Створення таблиці OrderDetails
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS `OrderDetails` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `product_name` VARCHAR(255) NOT NULL,
    `quantity` INT NOT NULL,
    `price` DECIMAL(10,2) NOT NULL,
    `order_date` DATE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SQL;
if ($conn->query($sql) !== TRUE) {
    die("Не вдалося створити таблицю: " . $conn->error);
}

// 5) Обробка додавання нового замовлення
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pname = trim($_POST['product_name']);
    $qty   = (int) $_POST['quantity'];
    $price = (float) $_POST['price'];
    $date  = $_POST['order_date'];

    if ($pname && $qty > 0 && $price >= 0 && $date) {
        $stmt = $conn->prepare(
            "INSERT INTO `OrderDetails` (product_name, quantity, price, order_date) VALUES (?, ?, ?, ?)"
        );
        $stmt->bind_param("sids", $pname, $qty, $price, $date);
        if ($stmt->execute()) {
            $message = "Замовлення додано успішно.";
        } else {
            $message = "Помилка додавання: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Будь ласка, заповніть усі поля коректно.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <title>Ініціалізація Orders і Додавання Замовлення</title>
</head>
<body>
  <h1>Ініціалізація бази даних. Orders</h1>
  <p>База даних і таблиця готові.</p>

  <h2>Додати нове замовлення</h2>
  <?php if ($message): ?>
    <p><strong><?= htmlspecialchars($message) ?></strong></p>
  <?php endif; ?>

  <form method="post">
    <label>Назва товару:<br>
      <input type="text" name="product_name" required>
    </label><br><br>
    <label>Кількість:<br>
      <input type="number" name="quantity" value="1" min="1" required>
    </label><br><br>
    <label>Ціна:<br>
      <input type="number" step="0.01" name="price" value="0.00" min="0" required>
    </label><br><br>
    <label>Дата замовлення:<br>
      <input type="date" name="order_date" value="<?= date('Y-m-d') ?>" required>
    </label><br><br>
    <button type="submit">Додати замовлення</button>
  </form>

  <p><a href="view_orders.php">Перейти до перегляду замовлень</a></p>
</body>
</html>
