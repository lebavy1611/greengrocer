<?php

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ApiResponser;

    /**
     * Construct parent Controller
     *
     * @return void
     */
    public function __construct()
    {
    }
}
