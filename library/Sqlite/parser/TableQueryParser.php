<?php
namespace DevHenry\Sqlite\Parser;
use DevHenry\Sqlite\Model\Field;
use DevHenry\Sqlite\Model\Fields;

/**
 * 
 * Returns an array containing the fields contained in a CREATE TABLE Query
 * @author Henry Oriaku <horiaku80@gmail.com>
 */
class TableQueryParser
{
    /**
     * This Function returns an array containing the fields contained in a CREATE TABLE Query
     * 
     * 
     * @param $query This is the SQL Query that Creates the table
     * @param $table_name This is the name of the table that will be created
     */
    function getFields($query, $table_name): Fields
    {
        $columns = $query;
                    
        $columns = preg_replace("/CREATE TABLE {$table_name} /", '', $columns);
        $columns = preg_replace('/FOREIGN KEY \([^\d]+/', '', $columns); //Remove the Foreign text and preceding
        $columns = preg_replace('/PRIMARY KEY/', '', $columns); //Remove the Foreign text and preceding
        $columns = preg_replace('/VARCHAR \(255\)|VARCHAR \(255\) /', 'text', $columns); //Remove the (255 text
        $columns = preg_replace('/NOT NULL|NOT NULL | NOT NULL/', ' required ', $columns);  //Replace the NOT NULL text with Required to suite html
        $columns = preg_replace('/INTEGER /', 'number ', $columns);  //Replace the NOT NULL text with Required to suite html
        $columns = preg_replace('/\(|\)/', '', $columns);
        $columns = trim($columns); //trim the result
        $columns = str_ends_with($columns, ',') ? substr_replace($columns, '', -1) : $columns; //Remove ant , at the end of result to avoid wrong explode | split result
        $columns = preg_replace('/\s,|,|\s,\s|,\s/', '~~', $columns);
        
        
        //print_r($columns);
        $columns = trim($columns); //trim the result
        //echo $columns;
        $columns = preg_split('/~~/', $columns); //Split the result by , to get a column and it's details

        $fields = new Fields();
        for ($i=0; $i < sizeof($columns); $i++) { 
            $column = trim($columns[$i]);
            $column = explode(' ',$column);
            $field = array();
            for($pos = 0; $pos < sizeof($column); $pos++)
            {
                $data = trim($column[$pos]);
                if(!($data == '')){
                    $field[] = $data;
                }
                
            }
            $name = trim($field[0]);
            //Convert Each First Letter in the field name to UpperCase
            $titles = preg_split('/_/',$name);
            $title = '';
            foreach($titles as $data)
            {
                $first_letter = strtoupper(substr($data, 0, 1));
                $data = $first_letter . substr($data, 1);
                $title .= $data . ' ';
            }

            $type = trim($field[1]);
                        
            $required = sizeof($field) > 2 ? $field[2] : ''; 
            $final = new Field(
                title: $title,
                name:$name,
                type:$type,
                required:$required
            );
            $fields[] = $final;
        }
        return $fields;
                    
    }
}