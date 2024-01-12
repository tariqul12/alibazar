<?php

namespace App\CPU;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use URL;
use Illuminate\Support\Facades\DB;
class ImageManager
{
    public static function upload(string $dir, string $format, $image = null, $is_url=false)
    {
        
        if ($image != null) {
            $imageName = Carbon::now()->toDateString() . "-" . uniqid() . "." . $format;
            if (!Storage::disk('public')->exists($dir)) {
                Storage::disk('public')->makeDirectory($dir);
            }
            Storage::disk('public')->put($dir . $imageName, file_get_contents($image));
            //for seo image upload
            $path=URL::to('/') . '/storage/app/public/'.$dir.$imageName;
            $file_size = getimagesize($path)['bits'];
            $alt_img=str_replace('/','_',$dir);
            if($is_url){
                $file_original_name = time().'_'.substr($image, strrpos($image, '/') + 1);
            }else{
                $file_original_name = $image->getClientOriginalName();
            }
            if(!empty(auth('admin')->user()->id))
            {
                $user_id=auth('admin')->user()->id;
            }
            if(!empty(auth('customer')->id()))
            {
                $user_id=auth('customer')->id();
            }
            $data=[
                "file_original_name"=>$file_original_name,
                "file_name"=>$imageName,
                "user_id"=>$user_id,
                "file_size"=>$file_size,
                "extension"=>$format,
                "type"=>"image",
                "img_alt_tag"=>$imageName
            ];
            DB::table('uploads')->insert($data);
        } else {
            $imageName = 'def.png';
        }

        return $imageName;
    }

    public static function update(string $dir, $old_image, string $format, $image = null)
    {
        if (Storage::disk('public')->exists($dir . $old_image)) {
            Storage::disk('public')->delete($dir . $old_image);
        }
        $imageName = ImageManager::upload($dir, $format, $image);
        return $imageName;
    }

    public static function delete($full_path)
    {
        if (Storage::disk('public')->exists($full_path)) {
            Storage::disk('public')->delete($full_path);
        }

        return [
            'success' => 1,
            'message' => 'Removed successfully !'
        ];

    }
}
