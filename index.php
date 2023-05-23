<?php
require('vendor/autoload.php');

use DevHenry\Sqlite\SQLiteConnection;

$pdo = (new SQLiteConnection())->connect();
if($pdo != null)
{
    print_r($pdo);
}else{
    print('Connected');
}