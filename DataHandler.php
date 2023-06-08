<?php

class DataHandler {
    private $fp;
    private $fileName;

    private $match_result = [];
    private $match_operator = 'operator';
    private $valid_operator = ['and', 'or'];
    private $valid_operator_flag;



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

    private function match($filter, $combinedRow): bool {
            $this->match_result = [];
            foreach($filter as $key => $value) {
                if($key == $this->match_operator) continue;
                
                $operator = trim($filter[$this->match_operator]);

                foreach($this->valid_operator as $operator_value) {
                    $this->valid_operator_flag = false;
                    if($operator_value == $operator){
                        $this->valid_operator_flag = true;
                        break;
                    }
                }

                if($this->valid_operator_flag){
                    $result = $this->$operator(trim($combinedRow[$key]) == trim($value));
                }
                else
                {
                    throw new Exception("Your operator: $operator is not valid");
                }
                
                if($operator == 'and' && !$result) break;
            }
        if($result) array_push($this->match_result, $combinedRow);
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

                for($i = 0; $i < count($filter); $i++) {

                    if($this->match($filter[$i], $combinedRow)) {
                        array_push($processedData, $this->match_result);
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