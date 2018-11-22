<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateManagerRequest;
use App\Models\Manager;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\ApiController;

class ManagerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->successResponse('index', Response::HTTP_OK);        
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
        $manager = Manager::create($request->all());
        foreach (array_values($request->account) as $account) {
                $accountId = empty($account['id']) ? null : $account['id'];
                $account['username'] = $request->username;
                $account['email'] = $request->email;
                $account['fullname'] = $request->fullname;
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
    public function update(Request $request, $id)
    {
        //
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
