<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Models\ProcessStatus;
use App\Http\Controllers\Api\ApiController;

class ProcessStatusController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $processStatuses = ProcessStatus::get();
            return $this->showAll($processStatuses);
        } catch (Exception $ex) {
            return $this->errorResponse("Process statuses can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
