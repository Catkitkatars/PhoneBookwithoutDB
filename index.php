<?php

require_once 'functions.php';
require_once 'fileName.php';
require_once 'DataHandler.php';


// var_dump($fileName);


// $dataHandler = new DataHandler('test.txt');


try
{
  $dataHandler = new DataHandler('test.txt');
}
catch (Exception $e)
{
  echo $e->getMessage();
  die();
}



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
try {
  $rows = $dataHandler->select(
    [
    [
      'name'=>'Egor', 
      'operator' => 'and', 
      'city' => 'Москва'
    ],
    [
      'name'=>'Семён', 
      'operator' => 'or', 
      'city' => 'Екатеринбург' 
    ]
  ]); 
} 
catch (Exception $e) 
{
  echo $e->getMessage();
  die();
}


// var_dump($rows);

// $arr = ['name'=>'Egor', 'city' => 'Москва'];


// var_dump($arr);


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
    <?php foreach ($row as $value):?>
    <tr>
      <td><?= htmlspecialchars($value['name']) ?></td>
      <td><?= htmlspecialchars($value['phone']) ?></td>
      <td><?= htmlspecialchars($value['email']) ?></td>
      <td><?= htmlspecialchars($value['city']) ?></td>
    </tr>
    <?php endforeach?>
  <?php endforeach ?>
</table>





