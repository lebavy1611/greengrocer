<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\CreateCommentRequest;
use App\Http\Requests\User\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Rating;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     */
    public function store(CreateCommentRequest $request)
    {
        try {
            $user = accountLogin();
            $data = $request->only([
                'product_id',
                'parent_id',
                'content'
            ]);
            $data['customer_id'] = $user->id;

            $comment = Comment::create($data);
            return $this->successResponse($comment, Response::HTTP_OK);
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
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        try {
            $user = accountLogin();
            if ($user->id == $comment->customer_id) {
                $data = $request->only([
                    'parent_id',
                    'content'
                ]);
                Comment::findOrFail($comment->id)->update($data);
                return $this->successResponse("Update conpon successfully", Response::HTTP_OK);
            }
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Coupon not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Coupon.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            accountLogin();
            Comment::findOrfail($id)->delete();
            return $this->successResponse("Delete comment successfully.", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Comment not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when delete comment.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
