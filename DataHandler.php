<?php

class DataHandler {
    private $fp;
    private $fileName;

    private $fp_offset;
    public $offset;
    public $micro_time;

    public function __construct($fileName)
    {
        $this->fileName = __DIR__ . '/' . $this->checkFileName($fileName);
        $this->fp = fopen($this->fileName, 'r+');

        $this->fp_offset = fopen(__DIR__ . '/' . $this->checkFileName('offset.txt'), 'r+');
        $this->offset = $this->offset_file_to_array();

        // $this->
    }
    
    private function checkFileName(string $fileName):string {
        if(!file_exists($fileName)){
            throw new Exception("File in: " . __DIR__ .'/'. $fileName . " not found.");
        }
        return $fileName;
    }

    private function offset_file_to_array() {
        $result = [];
        while ($row = fgets($this->fp_offset)) { 
            $row = $this->myExplode('|', $row);
            for($i = 1; $i < count($row); $i++) {
                if($i == 1) {
                    $result[$row[0]] = [];
                }
                array_push($result[$row[0]], $row[$i]);
            }
        }
        return $result;
    }

    

    public function myExplode($sep, $str){

        $sepQuote = preg_quote($sep); 

        $str = preg_split("/(?<!$sepQuote)$sepQuote(?!$sepQuote)/", $str);

        foreach($str as $key => $value) {
            if(str_contains($value, ("$sep"."$sep"))) {
                $str[$key] = strtr($value, [("$sep"."$sep") => "$sep"]);
            }
        }

        return $str;
    }

    public function combine($row) {
        $keys = ['name', 'phone', 'email', 'city'];
        $processedRow = array_combine($keys, $this->myExplode('|', $row));
        return $processedRow;
    }


    private function and($compare){
        return true && $compare;
    }

    private function or($compare): bool{
        return false || $compare;
    }

    private function match($row, $query): bool {
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

    public function offset_select($name) {
        foreach($this->offset as $key => $value) {
            if($key == $name){
                return $this->offset[$key];
            }
        }
    }

    public function offset_insert($name, $offset) {
        $offset = strval($offset);
        $name = trim($name);
        $offset_check = true;
        $offset_string = '';
        foreach($this->offset as $key => $value) {
            if ($key == $name) {
                $offset_check = false;
                array_push($this->offset[$key], $offset);
            }
        }
        if($offset_check) {
            $this->offset[$name] = [$offset];
        }
        
        $file_name = __DIR__ . "/" . $this->checkFileName('offset.txt');
        $fp = fopen($file_name, 'r+');

        foreach($this->offset as $key => $value) {
            fwrite($fp,($key . '|' . implode('|', $this->offset[$key]) . "\n"));
        }
    }

    public function offset_delete() {
        
    }

    public function offset_update() {

    }


    public function select($filter){
        $processedData = [];
        if(!$filter){
            while ($row = fgets($this->fp)) { 
                if($row[0] == '0') {
                    continue;
                }
                $row = preg_replace("/^.{2}/", '', $row);
                array_push($processedData, $this->combine($row));
            }
        } 
        else 
        {
            if($filter['operator'] == '=' && $filter['left'] == 'name') {
                $offsets = $this->offset_select($filter['right']);

                foreach($offsets as $value) {
                    fseek($this->fp, $value);
                    $row = fgets($this->fp);
                    $row = preg_replace("/^.{2}/", '', $row);
                    $combinedRow = $this->combine($row);
                    array_push($processedData, $combinedRow);
                }
            }
            else 
            {
                while ($row = fgets($this->fp)) { 
                    if($row[0] == '0') {
                        continue;
                    }
                    $row = preg_replace("/^.{2}/", '', $row);
                    $combinedRow = $this->combine($row);
    
                    if($this->match($combinedRow, $filter)) {
                        array_push($processedData, $combinedRow);
                    }
                }
            }
        }
        
        // !!!
        $this->micro_time = ' microtime(' . microtime() . ')' . ' memory(' . memory_get_usage() . ')';

        return $processedData;
    }

    public function insert($values){
        $name = '';
        
        foreach($values as $key => $value) {   
            $value = trim($value);

            if($key == 'name'){
                $name .= $values[$key];
            }

            if(str_contains($value, '|')) {
                $values[$key] = strtr($value, ['|' => '||']);
            }
        }
        
        fseek($this->fp, 0, SEEK_END);
        $offset = ftell($this->fp);
        $this->offset_insert($name, $offset);
        fwrite($this->fp,("1|" . implode('|', $values) . "\n"));
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