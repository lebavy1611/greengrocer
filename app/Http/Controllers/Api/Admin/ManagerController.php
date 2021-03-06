<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\CreateManagerRequest;
use App\Models\Manager;
use Illuminate\Http\Response;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\UpdateManagerRequest;
use App\Models\Role;
use App\Models\RoleResource;


class ManagerController extends ApiController
{
    protected $account;

    /**
     * CategoryController constructor..
     *
     * @param UploadImageService   $uploadImageService   UploadImageService
     */
    public function __construct()
    {
        $this->account = auth('api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $managers = Manager::with(['roleResources.resource:id,name', 'roleResources.role:id,name'])->managerFilter($request)->get();
            if ($managers->count()) {
                if ($this->account->can('view', $managers->first())) {
                    return $this->showAll($managers);
                } else {
                    return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
                }
            } else {
                return $this->showAll($managers);
            }
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
        if ($this->account->can('create', Manager::class)) {
            $request['password'] = bcrypt($request->password);
            $accounts = processParamAccount('App\Models\Manager');
            $manager = Manager::create($request->all());
            foreach (array_values($accounts) as $account) {
                $accountId = empty($account['id']) ? null : $account['id'];
                $account['email'] = $request->email;
                $account['password'] = $request['password'];
                $manager->accounts()->updateOrCreate(['id' => $accountId], $account);
            }
            
            $roleResourcesReq;
            $roleData['manager_id'] = $manager->id;
            switch ($request->role) {
                case 'mod':
                    $roleData['name'] = 'mod' . $manager->id;
                    if (count($request->role_resources)) {
                        $roleResourcesReq = $request->role_resources;
                    }
                    break;
                case 'admin':
                    $roleData['name'] = 'admin' . $manager->id;
                    $roleResourcesReq = config('define.admin_role_resources');
                    break;
                case 'provider':
                    $roleData['name'] = 'provider' . $manager->id;
                    $roleResourcesReq = config('define.provider_role_resources');
                    break;
            }
            $role = Role::create($roleData);
            $now = \Carbon\Carbon::now()->toDateTimeString();   
            array_walk($roleResourcesReq, function(&$role_resource, $key) use($role, $now) {
                $role_resource['role_id'] = $role->id;
                $role_resource['created_at'] = $now;
                $role_resource['updated_at'] = $now;
            });
            $roleResource = RoleResource::insert($roleResourcesReq);
            return $this->successResponse($manager->load(['roleResources.resource:id,name', 'roleResources.role:id,name']), Response::HTTP_OK);
        } else {
            return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
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
            $manager = Manager::with(['roleResources.resource:id,name', 'roleResources.role:id,name'])->findOrFail($id);
            if ($this->account->can('view', $manager)) {
                return $this->successResponse($manager, Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Không tìm thấy.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Đã có lỗi xảy ra", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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
            if ($this->account->can('update', $manager)) {
                $managerData = $request->all();
                if ($request->password) $managerData['password'] = bcrypt($request->password);
                $manager = Manager::updateOrCreate(['id' => $manager->id], $managerData);
                return $this->successResponse($manager, Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
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
    public function destroy(Manager $manager)
    {
        try {
            if ($this->account->can('delete', $manager)) {
                $manager->delete();
                return $this->successResponse('Xóa thành công', Response::HTTP_OK);
            } else {
                return $this->errorResponse(config('define.no_authorization'), Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return $this->errorResponse('Xóa thất bai', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get manager login
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getManagerLogin()
    {
        return $this->successResponse(accountLogin(), Response::HTTP_OK);
    }
}
