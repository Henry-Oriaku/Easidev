<?php


namespace DevHenry;
/**
 * A MySqli Connection Class
 */
class Connection
{
    /**
     * @package Connection
     */
    
    private static $connection;
    public static $DBNAME;
    private static bool $is_ready = false;
    public static function loadConnection(string|bool $HOST = 'localhost', string|bool $USER = 'root', string|bool $PASSWORD = '', string|bool $DBNAME = false): mixed
   {
        if($DBNAME){
            $result = self::$connection  = mysqli_connect($HOST, $USER, $PASSWORD, $DBNAME);
            self::$DBNAME = $DBNAME;

            if($result){
                self::$is_ready = true;
                return self::$connection;
            }else{
                return false;
            }
        }else{
            return false;
        }
        
    }

    public static function getConnection(): mixed
    {
        if(self::$is_ready){
            return self::$connection;
        }else{
            return false;
        }
        
    }

}