<?php

namespace DevHenry\Utils;
use DevHenry\Sqlite\SQLiteConnection;

/**
 * This Specifically Runs A Query
 * 
 * It will always run the query on `SQLITE`
 * If `MySQL` is configured, It will also run a *mysqli_query*
 * 
 */
class QueryRunner{

    private static \mysqli|bool $MYSQL = bool;

    /**
     * This is the query runner
     * @param string $query The Query To Run
     */
    public static function RUN_QUERY($query)
    {
        //Run it on SQLITE
        $pdo = (new SQLiteConnection())->connect();

        $pdo->exec($query);

        // if(self::$MYSQL){
        //     $result = mysqli_query(self::$MYSQL, $query);
        // }

        return $pdo;
    }

}