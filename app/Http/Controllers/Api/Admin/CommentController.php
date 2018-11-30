<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\Admin\CreateRatingRequest;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $comment = Comment::with(['inforUser','product.category:id,name', 'product.shop:id,name'])
                ->orderBy('created_at', 'desc')
                ->get();
            return $this->successResponse($comment, Response::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Comments can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $comment = Comment::with(['user','product.category:id,name', 'product.shop:id,name'])->findOrFail($id);
            return $this->successResponse($comment, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Comment not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Occour error when show comment.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            Comment::findOrfail($id)->delete();
            return $this->successResponse("Delete comment successfully.", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Comment not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when delete comment.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
