<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Admin\CreateCategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Carbon\Carbon;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Services\UploadImageService;
use Illuminate\Http\Request;
use DB;

class CategoryController extends ApiController
{
    protected $uploadImageService;

    /**
     * CategoryController constructor..
     *
     * @param UploadImageService   $uploadImageService   UploadImageService
     */
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $categories = Category::where('parent_id', 0)->with('children')->orderBy('position','ASC')->get();

            return $this->showAll($categories);
        } catch (Exception $ex) {
            return $this->errorResponse("Category can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
       
        try {
            $data = $request->only([
                'name', 'parent_id',
            ]);

            $maxPosition = Category::where([
                    'parent_id' => $data['parent_id'],
                ])->first([DB::raw('MAX(position) as position')])->position ?? 0;
            $data['position'] = $maxPosition + 1;

            $data['image'] = $this->uploadImageService->fileUpload($request, 'categories');

            $category = Category::create($data);    
            return $this->successResponse($category, Response::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex->getMessage());
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
            $category = Category::with('children')->findOrFail($id);
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
     * @param UpdateCategoryRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $data = $request->only([
                'name', 'parent_id', 'position'
            ]);

                Category::where([
                    'parent_id' => $data['parent_id'],
                    ['position', '>=', $data['position']],
                    ['id', '!=', $id],
                ])->update([
                    'position' => DB::raw ('position + 1')
                ]);

            if ($request->hasFile('image')) {
                $data['image'] = $this->uploadImageService->fileUpload($request, 'categories');
            }

                Category::findOrFail($id)->update($data);
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
            Category::findOrfail($id)->delete();
            return $this->successResponse("Delete category successfully.", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Catelory not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when delete category.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
