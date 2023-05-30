<?php

require_once 'functions.php';


$filePath = require_once 'filePath.php';
$editData = '';

$fp = fopen($filePath, 'r+');

// var_dump($filePath);

$rows = select($fp, []);
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





