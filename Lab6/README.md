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
$validDate = null;
$dateInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateInput = $_POST['date'] ?? '';

    // Розділяємо дату на рік, місяць і день
    $parts = explode('-', $dateInput);
    if (count($parts) === 3) {
        $year = (int)$parts[0];
        $month = (int)$parts[1];
        $day = (int)$parts[2];

        // Перевіряємо коректність дати
        $validDate = checkdate($month, $day, $year);
    } else {
        $validDate = false;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Перевірка дати</title>
</head>
<body>
    <h1>Перевірка коректності дати</h1>
    <form method="post" action="">
        <label>
            Введіть дату (РРРР-ММ-ДД):
            <input type="date" name="date" required value="<?php echo htmlspecialchars($dateInput); ?>">
        </label>
        <br><br>
        <button type="submit">Перевірити</button>
    </form>

    <?php if ($validDate !== null): ?>
        <h2>Результат</h2>
        <?php if ($validDate): ?>
            <p style="color: green;">Дата <strong><?php echo htmlspecialchars($dateInput); ?></strong> є коректною.</p>
        <?php else: ?>
            <p style="color: red;">Дата <strong><?php echo htmlspecialchars($dateInput); ?></strong> є некоректною.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>

```

[Перейти до коду]()

**Результат:**

[![Скріншот Завдання 2](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_first-scrn.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_first-scrn.png) 
[![Скріншот Завдання 2.1](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_second-scrn.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_second-scrn.png)

## Завдання 3


**Умова:**  
Створити функцію для видалення замовлення за його id


```php
<?php
$validDate = null;
$dateInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateInput = $_POST['date'] ?? '';

    // Розділяємо дату на рік, місяць і день
    $parts = explode('-', $dateInput);
    if (count($parts) === 3) {
        $year = (int)$parts[0];
        $month = (int)$parts[1];
        $day = (int)$parts[2];

        // Перевіряємо коректність дати
        $validDate = checkdate($month, $day, $year);
    } else {
        $validDate = false;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Перевірка дати</title>
</head>
<body>
    <h1>Перевірка коректності дати</h1>
    <form method="post" action="">
        <label>
            Введіть дату (РРРР-ММ-ДД):
            <input type="date" name="date" required value="<?php echo htmlspecialchars($dateInput); ?>">
        </label>
        <br><br>
        <button type="submit">Перевірити</button>
    </form>

    <?php if ($validDate !== null): ?>
        <h2>Результат</h2>
        <?php if ($validDate): ?>
            <p style="color: green;">Дата <strong><?php echo htmlspecialchars($dateInput); ?></strong> є коректною.</p>
        <?php else: ?>
            <p style="color: red;">Дата <strong><?php echo htmlspecialchars($dateInput); ?></strong> є некоректною.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>

```

[Перейти до коду]()

**Результат:**

[![Скріншот Завдання 3](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_first-scrn.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_first-scrn.png) 
[![Скріншот Завдання 2.1](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_second-scrn.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/lab5/Screenshots/Lab5_task2_second-scrn.png)
