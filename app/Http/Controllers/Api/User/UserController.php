<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Http\Controllers\Api\ApiController;
use App\Models\UserInfor;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
class UserController extends ApiController
{
    public function show()
    {
        try {
            $user = accountLogin();
            $userInfor = User::findOrFail($user->id)->load('userInfor');
            return $this->successResponse($userInfor, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("User not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show user.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request)
    {
        try {
            $user = accountLogin();
            User::updateOrCreate(['id' => $user->id]);
            $userInfoData = [
                'fullname' => $request->fullname,
                'address' => $request->address,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
            ];
            if ($request->password) $userInfoData['password'] = bcrypt($request->password);
            if ($request->hasFile('avatar')) {
                $userInfoData['avatar'] = $this->uploadImageService->fileUpload($request, 'users', 'avatar');
            }
            UserInfor::updateOrCreate(['user_id' => $user->id], $userInfoData);
            return $this->successResponse('Update user successfully', Response::HTTP_OK);
        } catch (Exception $e) {
            dd($e->getMessage());
            return $this->errorResponse('Update user failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
