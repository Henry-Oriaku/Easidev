<?php
namespace DevHenry\Sqlite;
use DevHenry\Sqlite\Config;
use PDO;

/**
 * SqliteConnection Establisher
 */
class SQLiteConnection
{
    /**
     * @var \PDO
     */
    public $pdo;

    /**
     * Connects to the db
     */
    public function connect()
    {
        if($this->pdo == null){
            $this->pdo = new PDO('sqlite:' . Config::DATABASE_PATH);
        }
        return $this->pdo;
    }
}