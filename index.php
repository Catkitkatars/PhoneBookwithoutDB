<?php

require_once 'functions.php';
require_once 'filePath.php';
require_once 'DataHandler.php';



$fp = fopen($filePath, 'r+');

$dataHandler = new DataHandler($fp);


// Проверить работу методов, которые записаны в класс DataHandler




// deleteElem($fp, [
//     'name' => 'Василий',
//     'phone' => '88005553535',
//     'email' => 'test1@test.ru',
//     'city' => 'г.Москва'
// ], $filePath);

// update($fp, $filePath, [
//     'name' => 'Максим',
//     'phone' => '89028728700'
// ], [
//     'name' => 'Артемий',
//     'phone' => '88004444044',
//     'email' => 'test3@test.ru',
//     'city' => 'г.Екатеринбург'
// ]);

// var_dump($update);

// $rows = select($fp, []);

// insert($filePath, [
//     'name' => 'Egor',
//     'phone' => '89005558423',
//     'email' => 'egor@test4.com',
//     'city' => 'Москва'
// ]);

// $rows = $dataHandler->select([]); // Done

// $dataHandler->insert($filePath,[ // Done
//     'name' => 'Egor',
//     'phone' => '89005558423',
//     'email' => 'egor@test4.com',
//     'city' => 'Москва'
// ]);

// $dataHandler->delete($filePath, [ // Done
//     'name' => 'Василий',
//     'phone' => '88005553535',
//     'email' => 'test1@test.ru',
//     'city' => 'г.Москва'
// ]);

// $dataHandler->update($filePath,[ // Done
//     'name' => 'Максим',
//     'phone' => '89028728700'
// ], [
//     'name' => 'Артемий',
//     'phone' => '88004444044',
//     'email' => 'test3@test.ru',
//     'city' => 'г.Екатеринбург'
// ]);

?>

<table>
  <?php foreach ($rows as $row): ?>
    <tr>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['city']) ?></td>
    </tr>
  <?php endforeach ?>
</table>





