<?php namespace App\BackupService;

use App\News;
use App\Feed;
use DB;
use Carbon\Carbon;

/**
 *
 */
set_time_limit(0);
ini_set('memory_limit', '512M');

class BackupService
{


    function backup_news()
    {

        $backup_path = base_path() . DS . 'news_backup';
        //disable foreign keys (to avoid errors)
        $return = 'SET FOREIGN_KEY_CHECKS=0;' . "\r\n";
        $return .= 'SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";' . "\r\n";
        $return .= 'SET AUTOCOMMIT=0;' . "\r\n";
        $return .= 'START TRANSACTION;' . "\r\n";
        $table = 'news';
        $news = News::where('created_at', '<', Carbon::now()->subDays(config('khabar.days')))->get()->toArray();

        $fields = DB::getSchemaBuilder()->getColumnListing('news');
        $num_fields = count($fields);
        $num_rows = count($news);
        $i_row = 0;

        $sql = "SHOW CREATE TABLE news";
        $result = DB::select($sql);
        $object = $result[0];

        $return .= "\n\n" . $object->{'Create Table'} . ";\n\n";


        if ($num_rows !== 0) {
            //$row3 = mysqli_fetch_fields($result);
            $return .= 'INSERT INTO ' . $table . '( ';
            foreach ($fields as $field) {
                $return .= '`' . $field . '`, ';
            }
            $return = substr($return, 0, -2);
            $return .= ' ) VALUES';


        }
        $i = 0;
        foreach ($news as $key => $value) {
            $return .= "\n(";

            foreach ($value as $field => $data) {


                $data = addslashes($data);
                $data = preg_replace("#\n#", "\\n", $data);
                if (isset($data)) {
                    $return .= '"' . $data . '"';
                } else {
                    $return .= '""';
                }
                if ($i++ < ($num_fields - 1)) {
                    $return .= ',';
                }

            }
            $i = 0;
            if (++$i_row == $num_rows) {
                $return .= ");"; // last row
            } else {
                $return .= "),"; // not last row
            }
        }
        $return .= "\n\n\n";


        // enable foreign keys
        $return .= 'SET FOREIGN_KEY_CHECKS=1;' . "\r\n";
        $return .= 'COMMIT;';

        //set file path
        if (!is_dir($backup_path)) {
            mkdir($backup_path, 0755, true);
        }


        $file_name = Carbon::now() . "";
        $file_name = str_replace(':', '.', $file_name);

        $handle = fopen($backup_path . DS . $file_name . '.sql', 'w+');
        fwrite($handle, $return);
        fclose($handle);


        //Delete the selected records
        News::where('created_at', '<', Carbon::now()->subDays(config('khabar.days')))->delete();

    }


}


