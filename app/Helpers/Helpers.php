<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;


class Helpers{
    public const CARS = 1;
    public const TRUCKS = 2;
    public const REAL_ESTATE = 3;
    public const HARDWARE = 4;
    public const SPARE_PARTS = 33;
    public const PETS = 41;
    public const CLOTHES = 40;
    public const JOBS = 43;
    public const SERVICES = 39;
    public const PLATES = 31;
    public const OTHERS = 42;



    public const NUM = 48121318;

    public static function upload_file($file, $folder, $width = 1000, $height = null){
        if ($file instanceof UploadedFile && $file->isValid()) {
            $fileName = $file->hashName();
            $publicDisk = Storage::disk('public');
            $pathLocation = public_path('app/public/'.$folder);
            if (!is_dir($pathLocation))
            {
                mkdir($pathLocation);
            }
            Image::make($file)->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            })->save("$pathLocation/$fileName");
            return $fileName;
        }
        return null;
    }

    public static function pageDirection($dir = null){
        if (is_null($dir)){
            return \LaravelLocalization::getCurrentLocaleDirection();
        }else{
            return \LaravelLocalization::getCurrentLocaleDirection() == $dir;
        }
    }

    public static function removePhoneNumb($str){
        $form = range(0, 9);
        $zero = strpos($str, '05', 1) ?: strpos($str, '5', 1);
        // return $zero;
        if ($zero && in_array($str[$zero + 2], $form)) {
            for ($i = $zero; $i < strlen($str); $i++) {
                if (in_array($str[$i], $form)) {
                    $nums[$i] = $str[$i];
                } else {
                    break;
                }
            }

            if (count($nums) == 9 || count($nums) == 10) {
                foreach ($nums as $k => $v) {
                    if (count($nums)  > ($k - 2)) {
                        $str[$k] = '*';
                    }
                }
            }

        }
        return $str;
    }

}
