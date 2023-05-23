<?php
namespace DevHenry;
/**
 * This class Registers the Models in the database
 */
use DevHenry\Model;

 class Loader extends Model
 {
    /**
     * The Registration function that register the Model
     */
    static function Load(Model $model)
    {
        if($model->Register())
        {
            $table_data = array();
            $table_data['table_name'] = $model->table_name;
            
            $columns  = $model->columns;

            $table_data['columns'] = $columns;
            $table_data['QUERY'] = $model->getQuery();
            self::generateFile($model->table_name . '.json', json_encode($table_data));
        }

    }

    private static function generateFile(string $filename, string $sql)
    {
        if(!(is_dir('./generated')))
         {
            mkdir('./generated');
         }
        file_put_contents('./generated/'.$filename, $sql);
    }
    function getGenerated(string $filename): string
    {
        if(!(is_dir('./generated')))
         {
            mkdir('./generated');
         }

        return file_get_contents("./generated/{$filename}.sql");
    }

    
 }