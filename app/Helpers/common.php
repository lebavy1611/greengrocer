<?php

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


if (!function_exists('isAdminLogin')) {
    /**
     * Check if current logged in user is Admin
     *
     * @return boolean
     */
    function isAdminLogin()
    {
        return Auth::check() && Auth::user()->loginable_type == App\Models\Account::TYPE_ADMIN;
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
