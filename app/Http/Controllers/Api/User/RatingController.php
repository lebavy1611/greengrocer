<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\CreateRatingRequest;
use App\Http\Requests\User\UpdateRatingRequest;
use App\Models\Rating;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class RatingController extends ApiController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(CreateRatingRequest $request)
    {
        try {
            $data = $request->only([
                'product_id',
                'stars',
                'content'
            ]);
            $data['customer_id'] = 1;

            $rating = Rating::create($data);
            return $this->successResponse($rating, Response::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Occour error when insert order.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRatingRequest $request, $id)
    {
        try {
//       $user = Auth::user();
//       if ($user->id == $order->user_id) {
            $data = $request->only([
                'stars',
                'content'
            ]);
            Rating::findOrFail($id)->update($data);
            return $this->successResponse("Update conpon successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Coupon not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Coupon.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
