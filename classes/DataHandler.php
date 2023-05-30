<?php
namespace classes;
class DataHendler {

    public $filePath;
    public $editData;

    public function __construct($filePath, $editData)
    {   
        $this->filePath = $filePath;
        $this->editData = $editData;
    }

    public function readFile(){
       return file($this->filePath);
    }
    public function editFile(){
        
    }
}