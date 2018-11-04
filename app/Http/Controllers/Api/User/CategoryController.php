<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\ApiController;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::where('parent_id', 0)->with('children')->orderBy('position','ASC')->get();
        return $this->showAll($categories, Response::HTTP_OK);
    }
}
