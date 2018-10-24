<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreatePaymentMethodRequest;
use App\Http\Requests\Admin\UpdatePaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class PaymentMethodController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $payments = PaymentMethod::get();
            return $this->showAll($payments);
        } catch (Exception $ex) {
            return $this->errorResponse("Payments can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePaymentMethodRequest $request)
    {
        try {
            $data = $request->only([
                'name',
            ]);
            $payment = PaymentMethod::create($data);

            return $this->successResponse($payment, Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when insert payment.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $payment = PaymentMethod::findOrFail($id);
            return $this->successResponse($payment, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Payment not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Payment.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentMethodRequest $request, $id)
    {
        try {
            $data = $request->only([
                'name',
            ]);
            PaymentMethod::findOrFail($id)->update($data);
            return $this->successResponse("Update payment successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Payment not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show payment.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
        try {
            PaymentMethod::findOrFail($id)->delete();
            return $this->successResponse("Delete payment successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Payment not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show payment.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
