<?php

class DataHandler {
    private $fp;
    private $fileName;







    public function __construct($fileName)
    {
        $this->fileName = __DIR__ . '/' . $this->checkFileName($fileName);
        $this->fp = fopen($this->fileName, 'r+');
    }
    
    private function checkFileName(string $fileName):string {
        if(!file_exists($fileName)){
            throw new Exception("File in: " . __DIR__ .'/'. $fileName . " not found.");
        }
        return $fileName;
    }

    private function combine($row) {
        $keys = ['name', 'phone', 'email', 'city'];
        $processedRow = array_combine($keys, explode(' ', $row));
        return $processedRow;
    }


    private function and($compare){
        return true && $compare;
    }

    private function or($compare){
        return false || $compare;
    }

    public function match($row, $query): bool {
        $left = NULL;
        $right = NULL;
        $result = false;
    
        if(is_array($query['left'])) {
            $left = $this->match($row, $query['left']);
        }
        else
        {
            $left = trim($row[$query['left']]); 
        }
    
        if(is_array($query['right'])) {
            $right = $this->match($row, $query['right']);
        }
        else
        {
            $right = trim($query['right']);
        }
    
        switch($query['operator']){
            case '=':
                $result = $left == $right;
                break;
            case '>':
                $result = $left > $right;
                break;
            case '<':
                $result = $left < $right;
                break;
            case '>=':
                $result = $left >= $right;
                break;
            case '<=':
                $result = $left <= $right;
                break;
            case 'or':
                $result = $left || $right;
                break;
            case 'and':
                $result = $left && $right;
                break;
        }
    
        return $result;
    }

    public function select($filter){
        $processedData = [];
        if(!$filter){
            while ($row = fgets($this->fp)) { 
                array_push($processedData, $this->combine($row));
            }
        } 
        else 
        {
            while ($row = fgets($this->fp)) { 
                $combinedRow = $this->combine($row);

                if($this->match($combinedRow, $filter)) {
                    array_push($processedData, $combinedRow);
                }
            }
        }
        return $processedData;
    }

    public function insert($filter){
        foreach($filter as $key => $value) {
            $value = trim($value);
        }
        file_put_contents($this->fileName, ("\n" . implode(' ', $filter)), FILE_APPEND);
    }

    public function delete($filter) {
        $allData = select($this->fp, []);

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
    
        file_put_contents($this->fileName, '');
        foreach($allData as $dataKey => $dataElem) {
            file_put_contents($this->fileName, implode(' ', $dataElem), FILE_APPEND);
        }
    }

    public function update($newDate, $filter){
        $allData = select($this->fp, []);

        foreach($allData as $allDataKey => $allDataValue){
            foreach($newDate as $newDateKey => $newDateValue) {
                if(trim($allDataValue[$newDateKey]) == trim($filter[$newDateKey])) {
                    $allData[$allDataKey][$newDateKey] = $newDateValue;
                }
            }
        }
        
        file_put_contents($this->fileName, '');
        foreach($allData as $dataKey => $dataElem) {
            file_put_contents($this->fileName, implode(' ', $dataElem), FILE_APPEND);
        }
    }
}