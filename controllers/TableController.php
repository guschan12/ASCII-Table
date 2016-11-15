<?php

class TableController{
    private $data;
    
    public function __construct()
    {
        $dataPath = ROOT.'/components/Data.php';
        $this->data = include $dataPath;
    }
    
    public function actionIndex()
    {
        $model = new Table; 
        $model->getTable($this->data);  
    }
    
}