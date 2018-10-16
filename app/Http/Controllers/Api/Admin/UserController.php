<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Response;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\UserInfor;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->role) {
            $users = User::with('userInfor', 'userRole:id,name')->filter($request)->paginate(config('define.limit_rows'));
            $users = $this->formatPaginate($users);
            return $this->showAll($users, Response::HTTP_OK);
        } else {
            $users = User::with('userInfor', 'userRole:id,name')->paginate(config('define.limit_rows'));
            $users = $this->formatPaginate($users);
            return $this->showAll($users, Response::HTTP_OK);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        try {
            $userData = [
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => $request->role_id,
                'active' => $request->active
            ];
            $user = User::create($userData);
            $newImage = '';
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $newImage = time() . '-' . str_random(8) . '.' . $image->getClientOriginalExtension();
            }
            $userInfoData = [
                'fullname' => $request->fullname,
                'address' => $request->address,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'avatar' => $newImage,
                'birthday' => $request->birthday,
            ];
            if ($user->userInfor()->create($userInfoData)) {
                if ($newImage) {
                    $destinationPath = public_path(config('define.images_path_users'));
                    $image->move($destinationPath, $newImage);
                }
            }
            return $this->successResponse('Create a new user successfully', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse('Create a new user failed', Response::HTTP_INTERNAL_SERVER_ERROR);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $userData = [
                'role_id' => $request->role_id,
                'active' => $request->active
            ];
            if ($request->password) $userData['password'] = bcrypt($request->password);
            User::updateOrCreate(['id' => $user->id], $userData);
            $newImage = '';
            $userInfoData = [
                'fullname' => $request->fullname,
                'address' => $request->address,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'birthday' => $request->birthday,
            ];
            if ($request->hasFile('avatar')) {
                $image = $request->file('avatar');
                $newImage = time() . '-' . str_random(8) . '.' . $image->getClientOriginalExtension();
                $userInfoData['avatar'] = $newImage;
            }
            if (UserInfor::updateOrCreate(['user_id' => $user->id], $userInfoData)) {
                if ($newImage) {
                    $destinationPath = public_path(config('define.images_path_users'));
                    $image->move($destinationPath, $newImage);
                }
            }
            return $this->successResponse('Update user successfully', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse('Update user failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->userInfor()->delete();
            $user->delete();
            return $this->successResponse('Delete a new user successfully.', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse('Delete a new user failed.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
