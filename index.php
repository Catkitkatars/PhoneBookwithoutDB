<?php

require_once 'functions.php';
require_once 'filePath.php';



$fp = fopen($filePath, 'r+');




deleteElem($fp, [
    'name' => 'Василий',
    'phone' => '88005553535',
    'email' => 'test1@test.ru',
    'city' => 'г.Москва'
], $filePath);


$rows = select($fp, []);

// insert($filePath, [
//     'name' => 'Egor',
//     'phone' => '89005558423',
//     'email' => 'egor@test4.com',
//     'city' => 'Москва'
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





