<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\CreateRatingRequest;
use App\Http\Requests\User\UpdateRatingRequest;
use App\Models\Order;
use App\Models\Rating;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
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

            $user = accountLogin();
            $rating = Rating::updateOrCreate([
                'product_id' => $request['product_id'],
                'customer_id' => $user->id
            ],[
                'stars' => $request['stars'],
                'content' => $request['content']
            ]);
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
    public function update(UpdateRatingRequest $request, Rating $rating)
    {
        try {
            $user = accountLogin();
            if ($user->id == $rating->customer_id) {

                $data = $request->only([
                    'stars',
                    'content'
                ]);
                Rating::findOrFail($rating->id)->update($data);
            }
           return $this->successResponse("Update conpon successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Coupon not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Coupon.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

}
