Лабораторна робота №2

**Тема:** Основи роботи з PHP  
**Виконавець:** Волошин Владислав  
**Група:** KNms1-B23  
**Дата виконання:** 28.04.2025  
**Варіант:** 3

---

## Завдання 1



**Умова:**  
Напишіть PHP-скрипт, який обчислює значення логарифма:
y = log10 x , де x = 100.



```php
<?php
$x = 100;
$y = log10($x);
echo "log10($x) = $y";
?>
```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab2/lab2_task1.php)

**Результат:**

[![Скріншот Завдання 1](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab2/Screenshots/lab2_task1.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab2/Screenshots/lab2_task1.png)

---

## Завдання 2



**Умова:**  
Напишіть PHP-скрипт, який демонструє використання рядкових змінних
та перетворення їх у числа.

```php
<?php

// Рядкові змінні
$str1 = "25";
$str2 = "7.5";
$str3 = "текст123"; // Неправильний формат для перетворення

// Перетворення в числа
$num1 = (int)$str1;     // Перетворення в ціле число
$num2 = (float)$str2;   // Перетворення у число з плаваючою комою
$num3 = (int)$str3;     // Перетворення рядка, що містить текст

// Виведення результатів
echo "Рядок str1 = '$str1' як число: $num1<br>";
echo "Рядок str2 = '$str2' як число: $num2<br>";
echo "Рядок str3 = '$str3' як число: $num3<br>";
?>
```

[Перейти до коду](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab2/lab2_task2.php)

**Результат:**

[![Скріншот Завдання 2](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab2/Screenshots/lab2_task2.png)](https://github.com/VoloshynVl/PHPLABS-Voloshyn/blob/main/Lab2/Screenshots/lab2_task2.png)
