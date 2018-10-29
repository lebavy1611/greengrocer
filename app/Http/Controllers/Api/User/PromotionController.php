<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use App\Models\Promotion;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Response;

class PromotionController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $promotions = Promotion::where('end_date', '>=', date("Y-m-d"))->orderBy('created_at', 'desc')->get();
        return $this->showAll($promotions, Response::HTTP_OK);
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
            $promotion = Promotion::findOrFail($id);
            return $this->successResponse($promotion, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Promotion not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Promotion.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
