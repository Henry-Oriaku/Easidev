<?php
namespace DevHenry;

//require(__DIR__.'/../../vendor/autoload.php');

use DevHenry\Connection;
use DevHenry\Sqlite\SQLiteConnection;
use DevHenry\Sqlite\TableManager;
use DevHenry\Utils\QueryRunner;
use Exception;


/**
 * @author Henry Oriaku <horiaku80@gmail.com>
 */
/**
 * This class Helps to automate the task of creating tables
 * Usage:
 * $user = new Model(table_name, the_columns | Model::INT(column_name, auto_increment(true or false)) | Model::TEXT('column_name'))
 * $user->Register();
 */
class Model
{

    private static $dbname;
    /**
     * The Generated MySqli Query
     */
    private string $query;
    /**
     * This will hold each of the columns in a positional manner
     * eg.
     * the first column - 1, second_column - 2
     */
    protected array $columns;

    /**
     * @param string $table_name The Name of the Table to Create
     * @param mixed $columns The Columns to add
     * @param string $mode 
     * `u` - update the table column if the table exists
     * `n` - delete and create a new table if the table exists
     */
    public function __construct(public string $table_name, array $columns, public string $mode = 'n')
    {
        /**
         * This Holds a String containing all the Column name and properties seperated by a comma
         */
        $all_column = '';




        foreach ($columns as $id => $column) {
            $column['ID'] = $id;
            $this->columns[$id] = $column;
        }

        print_r($columns);
        if (TableManager::tableExists($this->table_name)) {
            switch ($this->mode) {
                case 'u':
                    /**Try to load the already generated data if
                     * The table has been created before
                     */
                    try {
                        $previous_detail = json_decode(file_get_contents("generated/$table_name.json"), true);
                        $previous_columns = $previous_detail['columns'];

                        /**
                         * Check if any of the columns had an update
                         */
                        foreach ($previous_columns as $id => $previous_column) {
                            
                            if (array_key_exists($id, $columns)) {
                                $old_name = $previous_column['NAME'];
                                $new_name = $columns[$id]['NAME'];
                                $new_type = $columns[$id]['TYPE'];

                                print_r(($all_column == '' ? '' : ', ') . "ALTER COLUMN '$old_name' '$new_name' $new_type");
                               $all_column .= ($all_column == '' ? '' : ', ') . "ALTER COLUMN '$old_name' '$new_name' $new_type";
                            }
                            else{
                                $old_name = $previous_column['NAME'];
                                print_r(($all_column == '' ? '' : ', ') . "DROP  '$old_name'");
                               $all_column .= ($all_column == '' ? '' : ', ') . "DROP  '$old_name'";
                            }
                        }
                        foreach ($columns as $id => $column) {
                            
                            if (!array_key_exists($id, $previous_columns)) {
                                
                                $name = $column['NAME'];
                                $type = $column['TYPE'];

                                print_r(($all_column == '' ? '' : ', ') . "ADD '$name' $type");
                               $all_column .= ($all_column == '' ? '' : ', ') . "ADD '$name' $type";
                            }
                            
                        }
                        $this->query = "ALTER TABLE `{$table_name}` {$all_column}";
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                    # code...
                    break;

                case 'n':
                   
                    foreach ($columns as $id => $column) {
                        $all_column .= '`'. $column['NAME'] .'` '.$column['TYPE'];

                    }
                    $this->query = "CREATE TABLE `{$table_name}` (`sn` INT NOT NULL PRIMARY KEY {$all_column})";
                    break;
            }
        }else{
            foreach ($columns as $id => $column) {
                $all_column .= ', `'. $column['NAME'] .'` '.$column['TYPE'];

            }
            $this->query = "CREATE TABLE `{$table_name}` (`sn` INT NOT NULL PRIMARY KEY {$all_column})";
            
        }

    }


    /**
     * Load the default MySql connection
     */
    // public static function loadConnection(string|bool $HOST = 'localhost', string|bool $USER = 'root', string|bool $PASSWORD = '', string|bool $DBNAME = false)
    // {

    //     Connection::loadConnection($HOST ,$USER ,$PASSWORD ,$DBNAME );
    //     self::$dbname = $DBNAME;
    //     self::$pdo = Connection::getConnection();
    // }

    /**
     * Always Run this After Creating a model to register the Model in The Database
     */
    protected function Register()
    {
        $pdo = (new SQLiteConnection())->connect();
        if ($pdo) {

            try {
                // $result = mysqli_query($connection, $this->query);

                $result = QueryRunner::RUN_QUERY($this->query);
                print("\nTable Created");
            } catch (Exception $e) {

                $result = $e;
                file_put_contents('logs.log', $e);
                print("\nError: {$result->getMessage()} \nDetail: Line {$result->getLine()} of {$result->getFile()}");

            }


            return $result;
        } else {
            print(PHP_EOL . 'Load A Connection');
            return false;
        }
    }

    /**
     * This returns the generated query
     */
    public function getQuery(): string
    {
        return $this->query;
    }


    /**
     * @param $column_name This is the name of the Field
     * @param $type This is the type of the field
     * @param $id 
     * This is a `unique id` for field.
     * It will be used to know when you change the name or type of the field
     * `Note` it doesn't concern the database
     */
    public static function INT(string $column_name, bool $is_auto_increment): array
    {
        $auto_increment = $is_auto_increment ? 'AUTO_INCREMENT' : '';
        return (['NAME' => $column_name, 'TYPE' => "INT NOT NULL {$auto_increment}"]);
    }

    /**
     * @param $column_name This is the name of the Field
     * @param $id 
     * This is a `unique id` for field.
     * It will be used to know when you change the name or type of the field
     * `Note` it doesn't concern the database
     */
    public static function TEXT(string $column_name): array
    {

        return (['NAME' => $column_name, 'TYPE' => "TEXT NOT NULL"]);
    }
}