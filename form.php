<?php
mb_internal_encoding('UTF-8');

$pagetitle = 'Записи';
include 'includes/header.php';


//Нормализираме:
if ($_POST) {
    $date = date("d-m-Y");
    $expense = trim($_POST['expense']);
    $expense = str_replace('!', ' ', $expense);
    $sum = trim($_POST['sum']);
    $sum = (float) str_replace('!', ' ', $sum);
    $selectedgroup = (int) $_POST['type'];
    $error = false;

//Валидираме:
    $date = trim($_POST['date']);
    $date = strtotime("$date 00:00:01");


    if (!$date) {
        echo '<p>Грешен формат на датата! Моля използвайте следния формат (дд-мм-гггг или дд.мм.гггг)</p>';
        $error = true;
    }
    else
        $date = date('d-m-Y', $date);

    if (mb_strlen($expense) < 2) {
        echo '<p>Наименованието е прекалено кратко!</p>';
        $error = true;
    }
    if ($sum <= 0) {
        echo '<p>невалидна сума!</p>';
        $error = true;
    }
    if (!array_key_exists($selectedgroup, $groups)) {
        echo '<p>Невалидна група!</p>';
        $error = true;
    }
    if (!$error) {
        $result = $date . '!' . $expense . '!' . $sum . '!' . $selectedgroup . "\n";
        if (file_put_contents('data.txt', $result, FILE_APPEND)) {
            echo 'Записа е успешен!';
        }
    }
}
?>
<h1>Моля въведете информацията в полетата!</h1>
<form method="POST">
    <table class='noBorders'>
        <tr>
            <td>Дата:</td>
            <td><input type="text" name="date" />* За днешна дата, оставете полето празно!</td>
        </tr>
        <tr>
            <td>Наименование:</td>
            <td><input type="text" name="expense" /></td>
        </tr>

        <tr>
            <td>Сума:</td>
            <td><input type="number" name="sum"  /></td>
        </tr>
        <tr>
            <td>Вид:</td>
            <td>
                <select name="type">
                    <?php
                    foreach ($groups as $key => $value) {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>
                </select>
        </tr>

    </table>

    <?php
    include './includes/footer.php';
    ?><br>
    <form action>
        <div><input type="submit" value="Добави запис"/></div>
    </form>
    <form action="./index.php">
        <div><input type="submit" value="Към списъка"/></div>
    </form>
