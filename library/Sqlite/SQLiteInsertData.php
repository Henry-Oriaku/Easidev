<?php
namespace DevHenry\Sqlite;
use DevHenry\Sqlite\Parser\TableQueryParser;

class SQLiteInsertData
{
    public $query;
    /**
     * Return a SQL Query Insert Statement for the Particular Table
     * after Fetching the table create query from SQLiteCreateTable with the POSTED table name
     */
    function generateQuery($REQUEST)
    {
        
        $parser = new TableQueryParser();
        $tables_query = (new SQLiteCreateTable((new SQLiteConnection())->connect()))->getTableList();
        $table_name = $REQUEST['table_name'];
        
        foreach ($tables_query as $table_query) {
            if( $table_name == $table_query['name']){
                $fields = $parser->getFields($table_query['sql'], $table_name);
                break;
            }
        }

        /**
         * Just Like Insert Into Table (keys)
         */
        $keys = '';
        /**
         * Just Like Insert Into Table (keys) VALUES (values)
         */
        $values = '';

        foreach ($fields as $field) {
            $name = $field->getName();
            if(array_key_exists($name, $REQUEST)){
                $keys .= $keys == '' ? "{$name}" : ','."{$name}";
                
                $value = $REQUEST[$name];
                $values .= $values == '' ? "'{$value}'" : ", '{$value}'";

            }
            
        }
        $query = "INSERT INTO {$table_name} ({$keys}) VALUES ({$values})";
        

        $this->query = $query;
        return $query;
    }

    function runQuery(): mixed
    {
        $pdo = (new SQLiteConnection())->connect();

        $pdo->exec($this->query);
        //$stmt->execute();
        
        return $pdo->lastInsertId();
    }
}