<?php
require_once 'config/db.php';
$id = intval($_GET['id']);

// Получаем данные
$stmt = $conn->prepare("SELECT * FROM employees WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $gender = $_POST['gender'];
    $age = intval($_POST['age']);
    $marital_status = $_POST['marital_status'];
    $has_children = isset($_POST['has_children']) ? 1 : 0;
    $position = trim($_POST['position']);
    $academic_degree = trim($_POST['academic_degree']);

    if (empty($full_name)) $errors[] = "ФИО обязательно для заполнения.";
    if (!in_array($gender, ['Мужской', 'Женский'])) $errors[] = "Неверно указан пол.";
    if ($age <= 0 || $age > 120) $errors[] = "Введите корректный возраст.";
    if (!in_array($marital_status, ['Холост/Не замужем', 'Женат/Замужем'])) $errors[] = "Неверное семейное положение.";
    if (empty($position)) $errors[] = "Должность обязательна.";

    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE employees SET full_name=?, gender=?, age=?, marital_status=?, has_children=?, position=?, academic_degree=? WHERE id=?");
        $stmt->bind_param("ssissssi", $full_name, $gender, $age, $marital_status, $has_children, $position, $academic_degree, $id);
        $stmt->execute();
        $stmt->close();

        header("Location: index.php?success=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать сотрудника</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container">
    <h1>Редактировать данные сотрудника</h1>

    <?php if (!empty($errors)): ?>
        <div class="error">
            <?php foreach ($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label>ФИО:
            <input type="text" name="full_name" value="<?= htmlspecialchars($row['full_name']) ?>">
        </label>

        <label>Пол:
            <select name="gender">
                <option value="Мужской" <?= $row['gender'] == 'Мужской' ? 'selected' : '' ?>>Мужской</option>
                <option value="Женский" <?= $row['gender'] == 'Женский' ? 'selected' : '' ?>>Женский</option>
            </select>
        </label>

        <label>Возраст:
            <input type="number" name="age" value="<?= $row['age'] ?>">
        </label>

        <label>Семейное положение:
            <select name="marital_status">
                <option value="Холост/Не замужем" <?= $row['marital_status'] == 'Холост/Не замужем' ? 'selected' : '' ?>>Холост/Не замужем</option>
                <option value="Женат/Замужем" <?= $row['marital_status'] == 'Женат/Замужем' ? 'selected' : '' ?>>Женат/Замужем</option>
            </select>
        </label>

        <label>
            <input type="checkbox" name="has_children" <?= $row['has_children'] ? 'checked' : '' ?>>
            Есть дети
        </label>

        <label>Должность:
            <input type="text" name="position" value="<?= htmlspecialchars($row['position']) ?>">
        </label>

        <label>Ученая степень:
            <input type="text" name="academic_degree" value="<?= htmlspecialchars($row['academic_degree']) ?>">
        </label>

        <button type="submit">Сохранить изменения</button>
        <a href="index.php"><button type="button">Отмена</button></a>
    </form>
</div>
</body>
</html>