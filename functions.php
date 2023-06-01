<?php 

function combine($row) {
    $keys = ['name', 'phone', 'email', 'city'];
    $processedRow = array_combine($keys, explode(' ', $row));
    return $processedRow;
}

function update($file, $filePath, $newDate, $filter) {
    $allData = select($file, []);

    foreach($allData as $allDataKey => $allDataValue){
        foreach($newDate as $newDateKey => $newDateValue) {
            if(trim($allDataValue[$newDateKey]) == trim($filter[$newDateKey])) {
                $allData[$allDataKey][$newDateKey] = $newDateValue;
            }
        }
    }
    
    file_put_contents($filePath, '');
    foreach($allData as $dataKey => $dataElem) {
        file_put_contents($filePath, implode(' ', $dataElem), FILE_APPEND);
    }
}

function deleteElem($file, array $filter, $filePath){
    $allData = select($file, []);

    foreach($allData as $dataKey => $dataElem){
        $counter = 0;
        foreach ($filter as $key => $value) {
            if(trim($value) == trim($dataElem[$key])){
                $counter++;
                if($counter == count($dataElem)){
                    unset($allData[$dataKey]);
                }
            }
        }
    }

    file_put_contents($filePath, '');
    foreach($allData as $dataKey => $dataElem) {
        file_put_contents($filePath, implode(' ', $dataElem), FILE_APPEND);
    }
}

  
function select($file, array $filter):array {
    $processedData = [];
    if(!$filter){
        while ($row = fgets($file)) { 
            array_push($processedData, combine($row));
        }
    } 
    else 
    {
        while ($row = fgets($file)) { 
            $combinedRow = combine($row);
            foreach ($filter as $key => $value) {
                $value = trim($value);
                if($combinedRow[$key] == $value) {
                    array_push($processedData, $combinedRow);
                }
            }
        }
    }
    return $processedData;
}
    

function insert($filePath, array $fields) {
    foreach($fields as $key => $value) {
        $value = trim($value);
    }
    file_put_contents($filePath, ("\n" . implode(' ', $fields)), FILE_APPEND);
}

