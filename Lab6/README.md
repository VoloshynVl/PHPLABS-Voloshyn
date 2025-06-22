# Лабораторна робота №6


**Тема:** Взаємодія з MySQL. CRUD операції. 
**Виконавець:** Волошин Владислав  
**Група:** KNms1-B23  
**Дата виконання:** 19.05.2025  
**Варіант:** 3

---

## Завдання 1



**Умова:**  
Створити базу даних "Orders" та таблицю "OrderDetails" зі стовпцями: id, product_name, quantity, price, order_date.

```php
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
```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab6/create_orders_db.php)

**Результат:**

## [![Скріншот Завдання 1](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab6/Screenshots/Lab6_task1.png) 


## Завдання 2


**Умова:**  
Реалізувати сторінку для перегляду всіх замовлень із можливістю фільтрування за датою замовлення.

```php
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
```

[Перейти до коду]()

**Результат:**

[![Скріншот Завдання 2](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab6/Screenshots/Lab6_task2-first_scr.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab6/Screenshots/Lab6_task2-first_scr.png)
[![Скріншот Завдання 2.1](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab6/Screenshots/Lab6_task2-second_scr.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab6/Screenshots/Lab6_task2-second_scr.png)

## Завдання 3


**Умова:**  
Створити функцію для видалення замовлення за його id


```php
<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "Orders";

$error   = '';
$success = '';

// Підключення до БД
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка з'єднання: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['id'] ?? '';

    if (!ctype_digit($orderId)) {
        $error = "Невірний формат ID.";
    } else {
        // Підготовка та виконання запиту на видалення
        $stmt = $conn->prepare("DELETE FROM `OrderDetails` WHERE `id` = ?");
        $stmt->bind_param("i", $orderId);

        if ($stmt->execute()) {
            $success = "Замовлення #{$orderId} успішно видалено.";
        } else {
            $error = "Помилка видалення: " . htmlspecialchars($conn->error);
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Видалення замовлення</title>
    <style>
        body { font-family: sans-serif; padding: 1em; }
        .msg { margin-bottom: 1em; }
        .error { color: #c00; }
        .success { color: #0c0; }
        form { margin-bottom: 1em; }
    </style>
</head>
<body>
    <h1>Видалити замовлення</h1>

    <?php if ($error): ?>
        <p class="msg error"><?= $error ?></p>
    <?php elseif ($success): ?>
        <p class="msg success"><?= $success ?></p>
    <?php endif; ?>

    <form method="post">
        <label for="id">ID замовлення для видалення:</label><br>
        <input type="text" id="id" name="id" required>
        <button type="submit">Видалити</button>
    </form>

    <!-- Окрема кнопка для переходу до списку замовлень -->
    <button type="button" onclick="window.location.href='view_orders.php'">
        Перейти до списку замовлень
    </button>
</body>
</html>

```

[Перейти до коду]()

**Результат:**

[![Скріншот Завдання 3](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_first-scrn.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_first-scrn.png) 
[![Скріншот Завдання 2.1](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_second-scrn.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_second-scrn.png)
