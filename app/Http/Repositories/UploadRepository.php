<?php


namespace App\Http\Repositories;


use Carbon\Carbon;

class UploadRepository
{

    public static function upload($file)
    {
        $file_name = "";
        for ($i=0; $i<5; $i++){
            $file_name .= mt_rand(1,9);
        }

        $upload_file = $file_name.'.'.$file->extension();
        $file->move(public_path('uploads'),$upload_file);
        return $upload_file;

    }

    public static function formatDate($date)
    {
        try {
            return  with(new Carbon($date))->locale('fr')->isoFormat('DD MMMM Y');
        }catch (\Exception $e) {
            echo $e;
        }
    }

}
