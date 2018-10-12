<?php

namespace App\Http\Controllers\Api\Admin;

use App\Services\CreateCategoryService;
use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\CreateCategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class CategoryController extends ApiController
{

    /**
     * CreateCategoryService
     *
     * @var CreateCategoryService
     */
    public $createService;

    /**
     * Construct parent Controller
     *
     * @param CreateCategoryService $createService
     *
     * @return void
     */
    public function __construct(
        CreateCategoryService $createService
    ) {
        parent::__construct();
        $this->createService = $createService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories = Category::where('parent_id', 0)->with('children')->get();
            return $this->showAll($categories);
        } catch (Exception $ex) {
            return $this->errorResponse("Category can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        try {
            $data = $request->only([
                'name',
                'parent_id',
                'position',
            ]);
            $data['image'] = $request->file('image');

            $category = $this->createService->create($data);

            return $this->successResponse($category, Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when insert category.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return $this->successResponse($category, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Catelory not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show category.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateCategoryRequest $request, $id)
    {
        try {
            $data = $request->only([
                'name',
                'parent_id',
                'position',
                'image'
            ]);

            $category = Category::findOrFail($id)->update($data);
            return $this->successResponse("Update category successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Catelory not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show category.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $result = Category::findOrfail($id)->delete();
            return $this->successResponse("Delete category successfully.", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Catelory not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when delete category.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
