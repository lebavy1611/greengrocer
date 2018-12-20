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
            $rating = Rating::with(['user','product'])->where('customer_id', $customer_id)
                ->orderBy('created_at', 'desc')
                ->paginate(config('paginate.number_ratings'));
            if ($this->account->can('view', Rating::all()->first())) {
                return $this->formatPaginate($rating);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
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
            $rating = Rating::with(['user','product.rating:id,name', 'product.shop:id,name'])->findOrFail($id);
            if ($this->account->can('view', $rating)) {
                return $this->formatPaginate($rating);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
            return $this->successResponse($rating, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Rating not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show rating.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rating $rating)
    {
        try {
            if ($this->account->can('delete', $rating)) {
                $rating->delete();
                return $this->successResponse("Delete rating successfully.", Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Rating not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when delete rating.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
