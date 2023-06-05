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
            throw new Exception("File in: " . __DIR__ .'/'. $fileName . " not found. Error in DataHandler.php/16");
        }
        return $fileName;
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