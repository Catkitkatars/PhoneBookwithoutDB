<?php 


  
function select($file, array $filter):array {
    $keys = ['name', 'phone', 'email', 'city'];
    $processedData = [];
    if(!$filter){
        while ($row = fgets($file)) { 
            $row = array_combine($keys, explode(' ', $row));
            array_push($processedData, $row);
        }
    } 
    else 
    {
        // while ($row = fgets($file)) { 
        //     echo $row . '<br>';
        // }
    }
    return $processedData;
}
    

function insert($file, array $fields) {
    // ...
}