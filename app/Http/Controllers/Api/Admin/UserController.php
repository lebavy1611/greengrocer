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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use App\Services\UploadImageService;
class UserController extends ApiController
{
    protected $uploadImageService;

    protected $account;

    /**
     * CategoryController constructor..
     *
     * @param UploadImageService   $uploadImageService   UploadImageService
     */
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
        $this->account = auth('api')->user();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('userInfor')->paginate(config('define.limit_rows'));
        if ($this->account->can('view', User::all()->first())) {
            $users = $this->formatPaginate($users);
            return $this->showAll($users, Response::HTTP_OK);
        } else {
            return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
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
            if ($this->account->can('create', User::class)) {
                $userData = [
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                ];
                $user = User::create($userData);
                $userInfoData = [
                    'fullname' => $request->fullname,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'birthday' => $request->birthday,
                ];
                $userInfoData['avatar'] = $this->uploadImageService->fileUpload($request, 'users', 'avatar');
                $user->userInfor()->create($userInfoData);
                return $this->successResponse('Create a new user successfully', Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
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
        try {
            $user = User::findOrFail($id)->load('userInfor');
            if ($this->account->can('view', $user)) {
                return $this->successResponse($user, Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
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
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            if ($this->account->can('update', $user)) {
                if ($request->password) $userData['password'] = bcrypt($request->password);
                User::updateOrCreate(['id' => $user->id], $userData);
                $userInfoData = [
                    'fullname' => $request->fullname,
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'gender' => $request->gender,
                    'birthday' => $request->birthday,
                ];
                if ($request->hasFile('avatar')) {
                    $userInfoData['avatar'] = $this->uploadImageService->fileUpload($request, 'users', 'avatar');
                }
                UserInfor::updateOrCreate(['user_id' => $user->id], $userInfoData);
                return $this->successResponse('Update user successfully', Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
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
            if ($this->account->can('delete', $user)) {
                $user->userInfor()->delete();
                $user->delete();
                return $this->successResponse('Delete a new user successfully.', Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return $this->errorResponse('Delete a new user failed.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
