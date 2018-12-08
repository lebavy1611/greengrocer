<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\ApiController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


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
        foreach ($categories as $key => $category) {

            foreach ($category->children as $key => $category_children) {
                $product = Product::where('category_id', $category_children->id)->first();
                if (empty($product)) {
                    unset($category->children[$key]);
                }
            }

            $product = Product::where('category_id', $category->id)->first();
            if (empty($product)) {
                unset($categories[$key]);
            }
        }

        return $this->showAll($categories, Response::HTTP_OK);
    }

    /**
     * Display specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $category = Category::with('parentsProducts.images', 'childrenProducts.images')->findOrFail($id);
            return $this->showOne($category, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Catelory not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show category.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
