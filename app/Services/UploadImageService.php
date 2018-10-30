<?php
namespace App\Services;

use App\Http\Requests;
use Illuminate\Http\Request;
use Dropbox\Client;
use Dropbox\WriteMode;
use Carbon\Carbon;

class UploadImageService
{
    
    public function fileUpload($request, $pathSave, $image = 'image')
    {
        $destinationPath = '';
        $newImage = '';
        switch ($pathSave) {
            case 'categories':
                $destinationPath = config('define.images_path_categories');
                break;
            case 'shops':
                $destinationPath = config('define.images_path_shops');
                break;
            case 'users':
                $destinationPath = config('define.images_path_users');
                break;
            case 'promotions':
                $destinationPath = config('define.images_path_promotions');
                break;
            case 'products':
                $destinationPath = config('define.product.images_path_products');
                break;
                
        }
        if ($request->hasFile($image)) {
            $image = $request->file($image);
            $newImage = Carbon::now()->format('YmdHis_u') . '.' . $image->getClientOriginalExtension();
            $pulicPath = public_path($destinationPath);
            $image->move($pulicPath, $newImage);
            return $destinationPath . $newImage;
        }
        return config('define.product.no_image');;
    }
}
