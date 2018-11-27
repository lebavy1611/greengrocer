<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\Resource;
use App\Http\Controllers\Api\ApiController;

class ResourceController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $resources = Resource::all();
            return $this->showAll($resources);
        } catch (Exception $ex) {
            return $this->errorResponse("Danh sách trống!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
