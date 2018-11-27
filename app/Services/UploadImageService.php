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
                $destinationPath .= config('define.images_path_categories');
                break;
            case 'shops':
                $destinationPath .= config('define.images_path_shops');
                break;
            case 'users':
                $destinationPath .= config('define.images_path_users');
                break;
            case 'promotions':
                $destinationPath .= config('define.images_path_promotions');
                break;
            case 'products':
                $destinationPath .= config('define.product.images_path_products');
                break;
                
        }
        if ($request->hasFile($image)) {
            $image = $request->file($image);
            $newImage = Carbon::now()->format('YmdHis_u') . '.' . $image->getClientOriginalExtension();
            $pulicPath = public_path($destinationPath);
            $image->move($pulicPath, $newImage);
            return config('define.domain') . $destinationPath . $newImage;
        }
        return config('define.product.no_image');;
    }

    public function multiFilesUpload($request, $pathSave, $model, $images = 'images')
    {
        $destinationPath = '';
        $newImage = '';
        $model_id = '';
        switch ($pathSave) {
            case 'categories':
                $destinationPath .= config('define.images_path_categories');
                $model_id = 'category_id';
                break;
            case 'shops':
                $destinationPath .= config('define.images_path_shops');
                $model_id = 'shop_id';
                break;
            case 'users':
                $destinationPath .= config('define.images_path_users');
                $model_id = 'user_id';
                break;
            case 'promotions':
                $destinationPath .= config('define.images_path_promotions');
                $model_id = 'promotion_id';
                break;
            case 'products':
                $destinationPath .= config('define.product.images_path_products');
                $model_id = 'product_id';
                break;
                
        }
        $imagesData = [];
        if ($request->hasFile($images)) {
            $images = $request->file($images);
            foreach ($images as $image) {
                $newImage = Carbon::now()->format('YmdHis_u') . '.' . $image->getClientOriginalExtension();
                $pulicPath = public_path($destinationPath);
                $image->move($pulicPath, $newImage);
                $imagesData[] = [
                    $model_id => $model->id,
                    'path' =>  config('define.domain') . $destinationPath . $newImage
                ];
            }
        }
        return $imagesData;
    }
}
