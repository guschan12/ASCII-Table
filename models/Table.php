<?php

class Table{ 
    //define constants for the  murkup table
    const OFFSET_X   = 1;
    const OFFSET_Y   = 0;
    const JOIN_SYMB  = '=';
    const LINE_X_SYMB = '=';
    const LINE_Y_SYMB = '|';    

    //main function that  drawing the table
    public function getTable($data)
    {
        $newLine             = "\n";
        $columnsName    = $this->columnsName($data);
        $columnsLengths = $this->columnsLengths($data, $columnsName);
        $rowSeparator   = $this->rowSeperator($columnsLengths);
        $rowSpacer      = $this->rowSpacer($columnsLengths);
        $rowNames       = $this->rowNames($columnsName, $columnsLengths);

        echo '<pre>'.$newLine;

        echo $rowSeparator . $newLine;
        echo str_repeat($rowSpacer . $newLine, self::OFFSET_Y);
        echo $rowNames . $newLine;
        echo str_repeat($rowSpacer . $newLine, self::OFFSET_Y);
        echo $rowSeparator . $newLine;
        echo str_repeat($rowSpacer . $newLine, self::OFFSET_Y);
        foreach ($data as $rowCells) {
            $rowCell = $this->rowCells($rowCells, $columnsName, $columnsLengths);
            echo $rowCell . $newLine;
            echo str_repeat($rowSpacer . $newLine, self::OFFSET_Y);
        }
        echo $rowSeparator . $newLine;

        echo '</pre>';
    }

    //return array with headers of the table and sort them by alphabet
    protected function columnsName($data)
    {
        $allNames = array();
        foreach($data as $items)
        {
            foreach($items as $key => $value)
            {
                array_push($allNames, $key);
            }
            
        }
        $allNames = array_unique($allNames);
        sort($allNames);
        return $allNames;
    }

    //define the width for each colum
    protected function columnsLengths($data, $columnsName)
    {
        $lengths = array();
        foreach ($columnsName as $columnName) {
            $nameLength = strlen($columnName);
            $max           = $nameLength;
            foreach ($data as $row) {               
                $length = isset($row[$columnName]) ? strlen($row[$columnName]) : '';
                if ($length > $max) {
                    $max = $length;
                }
            }

            if (($max % 2) != ($nameLength % 2)) {
                $max += 1;
            }

            $lengths[$columnName] = $max;
        }

        return $lengths;
    }

    //inserts row separator based on the length of the colums
    protected function rowSeperator($columnsLengths)
    {
        $row = '';
        foreach ($columnsLengths as $columLength) {
            $row .= self::JOIN_SYMB . str_repeat(self::LINE_X_SYMB, (self::OFFSET_X * 2) + $columLength);
        }
        $row .= self::JOIN_SYMB;

        return $row;
    }

    //create space for the row
    protected function rowSpacer($columnsLengths)
    {
        $row = '';
        foreach ($columnsLengths as $columLength) {
            $row .= self::LINE_Y_SYMB . str_repeat(' ', (self::OFFSET_X * 2) + $columLength);
        }
        $row .= self::LINE_Y_SYMB;

        return $row;
    }

    //displays the table headings
    protected function rowNames($columnsName, $columnsLengths)
    {
        $row = '';
        foreach ($columnsName as $name) {
            $row .= self::LINE_Y_SYMB . str_pad($name, (self::OFFSET_X * 2) + $columnsLengths[$name], ' ', STR_PAD_LEFT);
        }
        $row .= self::LINE_Y_SYMB;

        return $row;
    }

    //displays the body of the table
    protected function rowCells($rowCells, $columnsName, $columnsLengths)
    {
        $row = '';
        foreach ($columnsName as $name) {
            $row .= self::LINE_Y_SYMB . str_repeat(' ', self::OFFSET_X) . str_pad(isset($rowCells[$name]) ? $rowCells[$name] : '', self::OFFSET_X + $columnsLengths[$name], ' ', STR_PAD_LEFT);
        }
        $row .= self::LINE_Y_SYMB;

        return $row;
    }
}