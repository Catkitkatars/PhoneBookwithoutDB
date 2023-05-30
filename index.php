<?php

use classes\DataHendler;

require_once 'classes/DataHandler.php';


$filePath = require_once 'filePath.php';
$editData = '';

$dataHandler = new DataHendler($filePath, $editData);




var_dump($dataHandler->readFile());


// $file = "/Users/mac/projects/lab/WEBwithoutBD/test.txt";

// $fpReader = file($file);

// // $data = 'not big test';

// file_put_contents($file, $fpReader);



// var_dump($fpReader);
// // var_dump($handle);