<?php
require_once 'config/db.php';

$sql = "SELECT * FROM employees";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Лаборатория - Сотрудники</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<h1>Сотрудники лаборатории</h1>
<a href="add.php">Добавить сотрудника</a>
<table border="1">
    <tr>
        <th>ФИО</th><th>Пол</th><th>Возраст</th><th>Семейное положение</th>
        <th>Дети</th><th>Должность</th><th>Ученая степень</th><th>Действия</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= htmlspecialchars($row['gender']) ?></td>
            <td><?= htmlspecialchars($row['age']) ?></td>
            <td><?= htmlspecialchars($row['marital_status']) ?></td>
            <td><?= $row['has_children'] ? 'Да' : 'Нет' ?></td>
            <td><?= htmlspecialchars($row['position']) ?></td>
            <td><?= htmlspecialchars($row['academic_degree']) ?></td>
            <td>
                <a href="edit.php?id=<?= $row['id'] ?>">Редактировать</a>
                <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Удалить?')">Удалить</a>
            </td>
        </tr>
    <?php endwhile; ?>
    <?php if (isset($_GET['success'])): ?>
        <div style="color:green; background:#eaffea; padding:10px; border-left:4px solid green;">
            Операция выполнена успешно!
        </div>
    <?php endif; ?>
</table>
</body>
</html>