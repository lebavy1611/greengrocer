<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use App\Services\UploadImageService;
use App\Models\Account;

class LoginController extends ApiController
{
    protected $uploadImageService;
    
    /**
     * CategoryController constructor..
     *
     * @param UploadImageService   $uploadImageService   UploadImageService
     */
    public function __construct(UploadImageService $uploadImageService)
    {
        $this->uploadImageService = $uploadImageService;
    }
    
    /**
     * Login as user
     *
     * @return json authentication code
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $account = Auth::user();
            $data['token'] =  $account->createToken('token')->accessToken;
            if (isAdminLogin()) {
                $data['manager'] = $account->loginable;
            } else {
                $data['user'] = $account->loginable->load('userInfor', 'userRole');
            }
            return $this->successResponse($data, Response::HTTP_OK);
        } else {
            return $this->errorResponse(config('define.login.unauthorised'), Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Logout
     *
     * @return 204
     */
    public function logout()
    {
        $user = Auth::user();
        $accessToken = $user->token();
        $accessToken->revoke();
        return $this->successResponse(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Register user
     *
     * @param App\Http\Requests\RegisterRequest $request validated request
     *
     * @return json authentication code with user info
     */
    public function register(RegisterRequest $request)
    {
        $userData = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'active' => $request->active
        ];
        $user = User::create($userData);
        $newImage = '';
        $userInfoData = [
            'fullname' => $request->fullname,
            'address' => $request->address,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'avatar' => $this->uploadImageService->fileUpload($request, 'users', 'avatar'),
            'birthday' => $request->birthday,
        ];
        $user->userInfor()->create($userInfoData);
        $accounts = processParamAccount('App\Models\User');
        foreach (array_values($accounts) as $account) {
            $accountId = empty($user['id']) ? null : $user['id'];
            $account['email'] = $request->email;
            $account['password'] = bcrypt($request->password);
            $user->accounts()->updateOrCreate(['id' => $accountId], $account);
        }
        $data['token'] =  Account::where([
            ['loginable_type', '=', 'App\Models\User'],
            ['loginable_id', '=', $user->id]])->first()->createToken('token')->accessToken;
        $data['user'] =  $user->load('userInfor','userRole');
        return $this->successResponse($data, Response::HTTP_OK);
    }

    /**
     * Check login token api
     *
     * @return \Illuminate\Http\Response
     */
    public function checkLoginToken()
    {
        if (Auth::user()) {
            $user = Auth::user();
            return $this->successResponse($user, Response::HTTP_OK);
        }
    }

    /**
     * Login as user
     *
     *@param Illuminate\Http\Request $request Request
     *
     * @return json authentication code
     */
    public function loginGplus(Request $request)
    {
        $user = User::firstOrNew([
            'email' => $request->email,
            'gplus_id' => $request->gplus_id
        ]);
        if (!$user->exists) {
            $user->username = $request->username;
            $user->full_name = $request->full_name;
            $user->birthday = '1996-11-16';
            $user->gender = 1;
            $user->phone = 'not found';
            $user->password = bcrypt('12345678');
            $user->gplus_id = $request->gplus_id;
            $user->role_id = 3;
        }
        if ($user->save()) {
            $data['token'] =  $user->createToken('token')->accessToken;
            $data['user'] =  $user;
            return $this->successResponse($data, Response::HTTP_OK);
        }
        return $this->errorResponse(config('define.login.unauthorised'), Response::HTTP_UNAUTHORIZED);
    }
}
