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
