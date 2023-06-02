<?php

class DataHandler {
    public $fp;
    public $filter;



    public function __construct($fp)
    {
        $this->fp = $fp;
    }

    private function combine($row) {
        $keys = ['name', 'phone', 'email', 'city'];
        $processedRow = array_combine($keys, explode(' ', $row));
        return $processedRow;
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

    public function insert($filePath, $filter){
        foreach($filter as $key => $value) {
            $value = trim($value);
        }
        file_put_contents($filePath, ("\n" . implode(' ', $filter)), FILE_APPEND);
    }

    public function delete($filePath, $filter) {
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
    
        file_put_contents($filePath, '');
        foreach($allData as $dataKey => $dataElem) {
            file_put_contents($filePath, implode(' ', $dataElem), FILE_APPEND);
        }
    }

    public function update($filePath, $newDate, $filter){
        $allData = select($this->fp, []);

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
}