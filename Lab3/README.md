# Лабораторна робота №3

**Тема:** Управління потоками виконання в PHP  
**Виконавець:** Волошин Владислав 
**Група:** KNms1-B23  
**Дата виконання:** 12.05.2025  
**Варіант:** 3

---

## Завдання 1



**Умова:**  
Напишіть програму для обчислення суми всіх непарних чисел від 1 до 50, використовуючи цикл for.

```php
<?php
$sum = 0;

for ($i = 1; $i <= 50; $i += 2) {
    $sum += $i;
}

echo "Сума всіх непарних чисел від 1 до 50: $sum";
?>
```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab3/Lab3_task1.php)

**Результат:**

[![Скріншот Завдання 1](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab3/Screenshots/Lab3_task1.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab3/Screenshots/Lab3_task1.png)

---

## Завдання 2


**Умова:**  
Створіть програму, яка за допомогою тернарного оператора визначає, чи є введене число більше за 10.

```php
<!-- Lab3_task2.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Перевірка числа</title>
</head>
<body>

<form method="post">
    Введіть число: <input type="number" name="number" required>
    <input type="submit" value="Перевірити">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $number = $_POST["number"];
    $result = ($number > 10) ? "Число більше за 10" : "Число не більше за 10";
    echo "<p>Результат: $result</p>";
}
?>

</body>
</html>
```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab3/Lab3_task2.php)

**Результат:**

[![Скріншот Завдання 2](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab3/Screenshots/Lab3_task2.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab3/Screenshots/Lab3_task2.png)

[![Скріншот Завдання 2](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab3/Screenshots/Lab3_task2_second_scr.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab3/Screenshots/Lab3_task2_second_scr.png)
