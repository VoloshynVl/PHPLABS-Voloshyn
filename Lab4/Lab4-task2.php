<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Квадрати чисел</title>
</head>
<body>
    <h2>Обчислення квадратів чисел</h2>
    <?php
    // Функція, яка обчислює квадрат числа
    function square($number) {
        return $number * $number;
    }

    // Масив чисел від 1 до 5
    $numbers = [1, 2, 3, 4, 5];

    // Застосовуємо функцію square до кожного елементу масиву
    $squares = array_map('square', $numbers);

    // Виводимо результати
    echo "<p><strong>Початкові числа:</strong> " . implode(', ', $numbers) . "</p>";
    echo "<p><strong>Квадрати чисел:</strong> " . implode(', ', $squares) . "</p>";
    ?>
</body>
</html>
