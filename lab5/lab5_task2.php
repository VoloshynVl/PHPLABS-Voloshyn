<?php
// date_check.php – форма для перевірки коректності введеної дати
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
