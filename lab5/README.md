# Лабораторна робота №5


**Тема:** Робота з формами в PHP  
**Виконавець:** Волошин Владислав  
**Група:** KNms1-B23  
**Дата виконання:** 28.04.2025  
**Варіант:** 3

---

## Завдання 1



**Умова:**  
Створіть форму для введення трьох чисел. Передайте їх методом GET і обчисліть їх
середнє арифметичне.

```php
<?php
// Перевіряємо, чи передані всі три значення через GET
$hasNumbers = isset($_GET['num1'], $_GET['num2'], $_GET['num3']);
$average = null;
if ($hasNumbers) {
    // Отримуємо значення та приводимо до числа з плаваючою комою
    $n1 = floatval($_GET['num1']);
    $n2 = floatval($_GET['num2']);
    $n3 = floatval($_GET['num3']);

    // Обчислюємо середнє арифметичне
    $average = ($n1 + $n2 + $n3) / 3;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Середнє арифметичне</title>
</head>
<body>
    <h1>Обчислення середнього арифметичного трьох чисел</h1>
    <form method="get" action="">
        <label>
            Число 1:
            <input type="number" name="num1" step="any" required value="<?php echo $hasNumbers ? htmlspecialchars($_GET['num1']) : ''; ?>">
        </label>
        <br>
        <label>
            Число 2:
            <input type="number" name="num2" step="any" required value="<?php echo $hasNumbers ? htmlspecialchars($_GET['num2']) : ''; ?>">
        </label>
        <br>
        <label>
            Число 3:
            <input type="number" name="num3" step="any" required value="<?php echo $hasNumbers ? htmlspecialchars($_GET['num3']) : ''; ?>">
        </label>
        <br><br>
        <button type="submit">Обчислити</button>
    </form>

    <?php if ($hasNumbers): ?>
        <h2>Результат</h2>
        <p>Середнє арифметичне трьох чисел (<?php echo $n1; ?>, <?php echo $n2; ?>, <?php echo $n3; ?>) = <strong><?php echo $average; ?></strong></p>
    <?php endif; ?>
</body>
</html>
```

[Перейти до коду]()

**Результат:**

## [![Скріншот Завдання 1]()]() 


## Завдання 2


**Умова:**  
Створіть форму для введення дати. Використовуйте метод POST. Перевірте, чи дата є
коректною, і виведіть повідомлення.

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

[![Скріншот Завдання 2]()]() 
[![Скріншот Завдання 2.1]()]()