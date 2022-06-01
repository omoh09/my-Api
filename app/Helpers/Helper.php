<?php 

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;

class Helper 
{
    public static function uploadPictures($pictures ,$model)
    {
        $files = $pictures;
        $folder = 'leo';

        foreach ($files as  $file){
            $size = getimagesize($file);
            $url  = cloudinary()->upload($file->getRealPath(),['folder' => $folder])->getSecurePath();
            
            if($url){
                $file = $model->files()->create(
                    [
                        'url' => $url,
                        'thumbnail' => $thumbnail
                    ]
                );
            }
        }

    }
}