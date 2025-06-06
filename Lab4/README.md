# Лабораторна робота №4



**Тема:** Робота з масивами та функціями в PHP  
**Виконавець:** Волошин Владислав  
**Група:** KNms1-B23  
**Дата виконання:** 12.05.2025  
**Варіант:** 3

---

## Завдання 1



**Умова:**  
Створіть масив із випадкових чисел від 1 до 100. Видаліть усі числа, які менші за 50, і виведіть результат.

```php
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
```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab4/Lab4-task1.php)

**Результат:**

[![Скріншот Завдання 1](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab4/Screenshots/Lab4_task1-first_scr.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab4/Screenshots/Lab4_task1-first_scr.png)
[![Скріншот Завдання 1](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab4/Screenshots/Lab4_task1-second_scr.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab4/Screenshots/Lab4_task1-second_scr.png)

---

## Завдання 2



**Умова:**  
Створіть функцію square($number), яка повертає квадрат числа. Використайте її для масиву чисел від 1 до 5.

```php
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
```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab4/Lab4-task2.php)

**Результат:**

[![Скріншот Завдання 2](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab4/Screenshots/Lab4-task2.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab4/Screenshots/Lab4-task2.png)
