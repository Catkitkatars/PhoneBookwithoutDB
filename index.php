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



// $a = $dataHandler->myExplode(' ', 'Egor 89005558423 egor@test4.com Нижний  Новгород');

// var_dump($a);

// $str = 'test hello  world';

// function explode1($sep, $str) {
//   $arr = [];
//   $str2 = '';
//   $marker = false;

//   for($i = 0; $i < strlen($str); $i++) {
//     if($str[$i] != $sep && $marker == false) { // Если элемент не равен пробелу и маркер равен отрицанию
//       $str2 .= $str[$i];                      // Присвой это значение к другим значениям в строке
//     }
//     if($str[$i] == $sep && $marker == true) { // Если элемент равен пробелу и маркер равен согласию
//       $str2 .= $sep;                          // Присвои строке пробел 
//       $marker = false;                        // Маркер переведи в отрицание
//       continue;                               // Пропусти итерацию
//     }
//     if($str[$i] == $sep) {
//       $marker = true;
//     }
//     if($str[$i] != $sep && $marker == true) {
//       array_push($arr, $str2);
//       $str2 = $str[$i];
//       $marker = false;
//     }
//   }
//   if($str2) array_push($arr, $str2);
//   return $arr;
// }



// $a = preg_match_all('/кошка/', $str);

// $b = preg_match_all('/\d+/', $str, $m);

// $c = preg_match_all('/\w+@\w+\.\w+/', $str, $m);

// =========================

// $c = preg_match_all('/\+\d+\(\d+\)\d+/', $str, $m);

// $str = 'https://cat.com'; // !!!!!!!!

// $c = preg_match_all('/https?:\/\/\S+/', $str, $m); // !!!!!!!!

// $str = 'duble notduble duble';

// $a = preg_match_all('/\b(\w+)\b(?=.*\b\1\b)/', $str, $m);

// var_dump($m);



// $str = "Глеб|8(947)4838372|address9@mail.info|Москва";

$rows = $dataHandler->select([
  'operator' => '=',
  'left' => 'name',
  'right' => 'Глеб'
]);




var_dump($dataHandler->micro_time);


// $rows = $dataHandler->select(
//   [
//     'operator' => 'and',
//     'left' => [
//         'operator' => '=',
//         'left' => 'name',
//         'right' => 'Виктория',
//     ],
//     'right' => [
//         'operator' => '=',
//         'left' => 'phone',
//         'right' => '8(949)7102519',
//     ],
//   ]); 




// $ftell = $dataHandler->insert([ // Done
//   'name' => 'Князь',
//   'phone' => '8(947)4838372',
//   'email' => 'address9@mail.info',
//   'city' => 'Москва'
// ]);
// $ftell = $dataHandler->insert([ // Done
//   'name' => 'Глеб',
//   'phone' => '8(947)4838372',
//   'email' => 'address9@mail.info',
//   'city' => 'Москва'
// ]);
// $ftell = $dataHandler->insert([ // Done
//   'name' => 'Жлоб',
//   'phone' => '8(947)4838372',
//   'email' => 'address9@mail.info',
//   'city' => 'Москва'
// ]);



// $insert = $dataHandler->offset_insert('ivan', '123456');
// $b = $dataHandler->offset_insert('ivan', '654321');
// // var_dump($ftell);
// $a = $dataHandler->offset;

// var_dump($a);



// $rows = $dataHandler->select(
//   []);

// $arr = ['name'=>'Egor', 'city' => 'Москва'];

// var_dump($arr);

// $names = [
//   "Василий",
//   "Борис",
//   "Никита",
//   "Константин",
//   "Юлия",
//   "Кристина",
//   "Виктория",
//   "Глеб",
//   "Евгений",
//   "Тамара"
// ];

// $mails = [
//   "address1@mail.info",
//   "address2@mail.info",
//   "address3@mail.info",
//   "address4@mail.info",
//   "address5@mail.info",
//   "address6@mail.info",
//   "address7@mail.info",
//   "address8@mail.info",
//   "address9@mail.info",
//   "address10@mail.info"
// ];

// $citys = [
//   "Москва",
//   "Санкт-Петербург",
//   "Новосибирск",
//   "Екатеринбург",
//   "Нижний Новгород",
//   "Казань",
//   "Челябинск",
//   "Омск",
//   "Самара",
//   "Ростов-на-Дону"
// ];

// function arrayGenerate($a, $c, $d)
// {
//   $str = "8" . '(' . rand(900, 999) . ')' . rand(1111111, 9999999);

//   return $a[array_rand($a)] ."|". $str ."|". $c[array_rand($c)] ."|". $d[array_rand($d)];
// }




// var_dump($str);

// for($i = 0; $i < 10000; $i++) {
//   $dataHandler->insert(
//     $dataHandler->combine(arrayGenerate($names, $mails, $citys))
//   );
// }

// var_dump($dataHandler->combine(arrayGenerate($names, $phones, $mails, $citys)));

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





