<?php

use App\Models\Coupon;
use App\Models\Order;
use App\Models\RoleResource;
use App\Models\Role;
use App\Models\Resource;

if (!function_exists('accountLogin')) {
    /**
     * Check if current logged in user is Admin
     *
     * @return boolean
     */
    function accountLogin()
    {
        return auth('api')->user()->loginable;
    }
}


if (!function_exists('isManagerLogin')) {
    /**
     * Check if current logged in user is Admin
     *
     * @return boolean
     */
    function isManagerLogin()
    {
        return Auth::check() && Auth::user()->loginable_type == App\Models\Account::TYPE_ADMIN;
    }
}

if (!function_exists('isAdminLogin')) {
    /**
     * Check if current logged in user is Admin
     *
     * @return boolean
     */
    function isAdminLogin()
    {
        return auth('api')->user()->loginable->role == App\Models\Manager::ROLE_ADMIN;
    }
}

if (!function_exists('isProviderLogin')) {
    /**
     * Check if current logged in user is Admin
     *
     * @return boolean
     */
    function isProviderLogin()
    {
        return auth('api')->user()->loginable->role == App\Models\Manager::ROLE_PROVIDER;
    }
}

if (!function_exists('isModLogin')) {
    /**
     * Check if current logged in user is Admin
     *
     * @return boolean
     */
    function isModLogin()
    {
        return auth('api')->user()->loginable->role == App\Models\Manager::ROLE_MOD;
    }
}
if (!function_exists('isUserLogin')) {
    /**
     * Check if current logged in user is Agent
     *
     * @return boolean
     */
    function isUserLogin()
    {
        return Auth::check() && Auth::user()->loginable_type == App\Models\Account::TYPE_USER;
    }
}

if (!function_exists('currentRole')) {
    /**
     * Check if current logged in user
     *
     * @return string
     */
    function currentRole()
    {
        if (Auth::user()) {
            return Auth::user()->loginable_type;
        }
    }
}

if (!function_exists('currentLoginAbleId')) {
    /**
     * Check if current logged in user
     *
     * @return int
     */
    function currentLoginAbleId()
    {
        return Auth::user()->loginable_id;
    }
}

if (!function_exists('getCompanyName')) {
    /**
     * Get Name of Company
     *
     * @return int
     */
    function getCompanyName()
    {
        switch (currentRole()) {
            case App\Models\Account::TYPE_COMPANY:
                return  Auth::user()->loginable->company_name;
            case App\Models\Account::TYPE_BRANCH:
                return Auth::user()->loginable->company->company_name;
        }
    }
}

if (!function_exists('getCompanyId')) {
    /**
     * Get Id Company
     *
     * @return int
     */
    function getCompanyId()
    {
        switch (currentRole()) {
            case App\Models\Account::TYPE_COMPANY:
                return  Auth::user()->loginable->id;
            case App\Models\Account::TYPE_BRANCH:
                return Auth::user()->loginable->company->id;
        }
    }
}

if (!function_exists('processParamAccount')) {
    /**
     * Get Id Company
     *
     * @return int
     */
    function processParamAccount($loginableType)
    {
        $account = [];
        $accounts = [];
        array_push($account, $loginableType);
        array_push($accounts, $account);
        return $accounts;
    }
}

if (!function_exists('getRandomString')) {
    /**
     * Random a string
     *
     * @param int $length String
     *
     * @return string
     */
    function getRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('getCode')) {
    /**
     * Random a string
     *
     * @param int $length String
     *
     * @return string
     */
    function getCodeCoupon($length) {
        while (true) {
            $code = getRandomString(8);
            $checkCode = Coupon::where(['code' => $code])->count();
            if (!$checkCode) {
                return $code;
            }
        }
    }
}

if (!function_exists('getCodeOrder')) {
    /**
     * Random a string
     *
     * @param int $length String
     *
     * @return string
     */
    function getCodeOrder($length) {
        while (true) {
            $code = getRandomString(8);
            $checkCode = Order::where(['code' => $code])->count();
            if (!$checkCode) {
                return $code;
            }
        }
    }
}
if (!function_exists('getRoleResource')) {
    /**
     * Get Id Company
     *
     * @return int
     */
    function getRoleResource($resource)
    {
        return RoleResource::where([
            ['role_id', Role::where('manager_id', accountLogin()->id)->first()->id],
            ['resource_id', Resource::where('name', '=', $resource)->first()->id]
        ])->first();
    }
}

if (!function_exists('checkOrderBelongsProvider')) {
    /**
     * Get Id Company
     *
     * @return int
     */
    function checkOrderBelongsProvider($resource)
    {
        return RoleResource::where([
            ['role_id', Role::where('manager_id', accountLogin()->id)->first()->id],
            ['resource_id', Resource::where('name', '=', $resource)->first()->id]
        ])->first();
    }
}
