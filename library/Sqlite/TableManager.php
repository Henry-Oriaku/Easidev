<?php
namespace DevHenry\Sqlite;
use PDO;

/**
 * SQLite Create Table Demo
 */
class TableManager
{
    /**
     * PDO object
     * @var \PDO
     */
    //private static $pdo = (new SQLiteConnection())->connect();

    /**
     * connect to the SQLite database
     */
    // public function __construct($pdo)
    // {
    //     $this->pdo = $pdo;
    // }

    /**
     * Create a table
     */
    // public static function createTable($query): mixed
    // {
    //     // $commands = ['CREATE TABLE IF NOT EXISTS projects (
    //     //     project_id   INTEGER PRIMARY KEY,
    //     //     project_name TEXT NOT NULL
    //     //   )',
    //     //     'CREATE TABLE IF NOT EXISTS tasks (
    //     // task_id INTEGER PRIMARY KEY,
    //     // task_name  VARCHAR (255) NOT NULL,
    //     // completed  INTEGER NOT NULL,
    //     // start_date TEXT,
    //     // completed_date TEXT,
    //     // project_id VARCHAR (255),
    //     // FOREIGN KEY (project_id)
    //     // REFERENCES projects(project_id) ON UPDATE CASCADE
    //     //                                 ON DELETE CASCADE)'
    //     // ];

    //     //foreach($query as $command){
    //     $pdo = (new SQLiteConnection())->connect();
    //     $pdo->exec($query);
    //     //}
    //     return $pdo;

    // }

    //public static function updateTableColumn()
    /**
     * Checks if a table exists
     */
    public static function tableExists($table_name): bool
    {
        $tables = self::getTableList();

        foreach ($tables as $table) {
            if($table['name'] == $table_name){
                return true;
            }
        }
        return false;
    }
    static function getTableList(): mixed
    {
        $pdo = (new SQLiteConnection())->connect();
        $stmt = $pdo->query("SELECT * FROM sqlite_master WHERE type = 'table' ORDER BY name");

        $tables = [];

        while($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $tables[] = [
                'name'=>$row['name'],
                'sql' => $row['sql']
            ];
            //print_r($row);
        }
        return $tables;
        
    }
    
}

