<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateManagerRequest;
use App\Models\Manager;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\UpdateManagerRequest;

class ManagerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $managers = Manager::all();
            return $this->showAll($managers);
        } catch (Exception $ex) {
            return $this->errorResponse("Danh sách trống!", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateManagerRequest $request)
    {
        $request['password'] = bcrypt($request->password);
        $accounts = processParamAccount('App\Models\Manager');
        $manager = Manager::create($request->all());
        foreach (array_values($accounts) as $account) {
                $accountId = empty($account['id']) ? null : $account['id'];
                $account['email'] = $request->email;
                $account['password'] = $request['password'];
                $manager->accounts()->updateOrCreate(['id' => $accountId], $account);
        }
        return $this->successResponse('Create a new manager successfully', Response::HTTP_OK);
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
    public function update(UpdateManagerRequest $request, Manager $manager)
    {
        try {
            $managerData = $request->all();
            if ($request->password) $managerData['password'] = bcrypt($request->password);
            Manager::updateOrCreate(['id' => $manager->id], $managerData);
            return $this->successResponse('Cập nhật thành công', Response::HTTP_OK);
        } catch (Exception $e) {
            return $this->errorResponse('Cập nhập thất bại', Response::HTTP_INTERNAL_SERVER_ERROR);
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
        //
    }
}
