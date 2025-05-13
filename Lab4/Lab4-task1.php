<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Фільтрація масиву</title>
</head>
<body>
    <h2>Фільтрація масиву</h2>
    <?php
    // Створюємо масив із 20 випадкових чисел від 1 до 100
    $numbers = [];
    for ($i = 0; $i < 20; $i++) {
        $numbers[] = rand(1, 100);
    }

    // Фільтруємо масив, залишаючи тільки числа >= 50
    $filtered = array_filter($numbers, function($num) {
        return $num >= 50;
    });

    // Виводимо результати
    echo "<p><strong>Початковий масив:</strong> " . implode(', ', $numbers) . "</p>";
    echo "<p><strong>Відфільтрований масив (числа ≥ 50):</strong> " . implode(', ', array_values($filtered)) . "</p>";
    ?>
</body>
</html>
