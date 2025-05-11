<?php
// average.php – форма для вводу трьох чисел та обчислення їх середнього арифметичного
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
