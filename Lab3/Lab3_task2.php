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
