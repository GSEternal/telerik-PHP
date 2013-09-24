<?php
$pagetitle = 'Разходи';

include 'includes/header.php';
?>

<h1>Направени разходи</h1>

<form method="POST">
    <div>
        <span>Вид:
            <select name="type">
                <?php
                /* да се показва избраната стойност, а не тази по подразбиране */
                if (!$_POST['type'] || $_POST['type'] == 'all') {
                    echo '<option value="all" selected >Всички</option>';
                    foreach ($groups as $key => $type_value) {
                        echo '<option value="' . $key . '">' . $type_value . '</option>';
                    }
                } else {
                    echo '<option value="all" >Всички</option>';
                    foreach ($groups as $key => $type_value) {
                        if ($_POST['type'] == $key) {
                            $selected = 'selected';
                        } else {
                            $selected = '';
                        }
                        echo '<option value="' . $key . '"' . $selected . '>' . $type_value . '</option>';
                    }
                }
                ?>	
            </select>

        </span>
        <span><input type="submit" value="Филтрирай" /></span>
    </div>
</form>
<table class="gridtable">
    <tr>
        <th>№</th><th>Дата</th><th>Наименование</th>
        <th>Сума</th><th>Вид</th><th>Редакция</th><th>Изтриване</th>
    </tr>
    <?php
    $sum = 0;
    if (file_exists('data.txt')) {
        $result = file('data.txt');
        $i = 1;

        if ($_POST['type'] && $_POST['type'] != 'all') {
            $selectedgroup = $_POST['type'];
        }
        foreach ($result as $value) {
            $columns = explode('!', $value);
            if (isset($selectedgroup) && $columns[3] != (int) $selectedgroup) {
                continue;
            }

            echo '<tr>
                        <td>' . $i++ . '</td>
                        <td>' . $columns[0] . '</td>
                        <td>' . $columns[1] . '</td>
                        <td>' . $columns[2] . '</td>
                        <td>' . $groups[trim($columns[3])] . '</td>
                       </td><td><a href=\"form.php?action=change&index=$index\">Редактирай</a>
                        </td><td><a href=\"form.php?action=delete&index=$index\">Изтрий</a>
                                              
</tr>';
            $sum+= (float) $columns[2];
        }
        $sum = round($sum, 2);
    } else {
        echo '<tr>
    <td>' . $i++ . '</td>
<td>' . $columns[0] . '</td>
<td>' . $columns[1] . '</td>
<td>' . $columns[2] . '</td>
<td>' . $groups[trim($columns[3])] . '</td>
</tr>';
        $sum+= (float) $columns[2];
    }

    $sum = round($sum, 2);
    ?>
    <tr>
        <td> </td>
        <td> -- </td>
        <td> -- </td>
        <td><?php echo $sum ?></td>
        <td> -- </td>
    </tr>
</table>

<?php
include './includes/footer.php';
?><br>
<form action="./form.php">
    <div><input type="submit" value="Нов запис"/></div>
</form>
