<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use App\Services\UploadImageService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
class UploadImageController extends ApiController
{

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->uploadImageService->dropboxFileUpload();
    }

    public function uploadToDropbox(){
        $contents = Storage::get('ThXEsXZYnsXdv4Xfqc9w0tSxT4zrSKRduDFSpcUp.png');
        return view('dropbox', compact('contents'));
    }

    public function uploadToDropboxFile(Request $RequestInput){
        $file_src=$RequestInput->file("upload_file"); //file src
        $is_file_uploaded = Storage::disk('dropbox')->put('public-uploads',$file_src);
        
        if($is_file_uploaded){
            return Redirect::back()->withErrors(['msg'=>'Succesfuly file uploaded to dropbox']);
        } else {
            return Redirect::back()->withErrors(['msg'=>'file failed to uploaded on dropbox']);
        } 
    }
}
