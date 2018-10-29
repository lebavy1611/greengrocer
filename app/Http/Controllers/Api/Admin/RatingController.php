<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreateRatingRequest;
use App\Models\Rating;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class RatingController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $customer_id = 1;
            $rating = Rating::with(['user','product'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate(config('paginate.number_ratings'));
            return $this->formatPaginate($rating);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Ratings can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $rating = Rating::with(['user','product'])->findOrFail($id);
            return $this->successResponse($rating, Response::HTTP_OK);
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
            Rating::findOrfail($id)->delete();
            return $this->successResponse("Delete category successfully.", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Catelory not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when delete category.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
