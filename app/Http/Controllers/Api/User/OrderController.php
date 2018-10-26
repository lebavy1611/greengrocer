<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\CreateOrderController;
use App\Http\Requests\User\UpdateOrderController;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $customer_id = 3;
            $order = Order::with(['user','payment','coupon'])->where('customer_id', $customer_id)->orderBy('created_at', 'desc')->paginate(config('paginate.number_orders'));
            return $this->formatPaginate($order);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Orders can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * processing_status = 1 Dang xu ly
     * processing_status = 2 Da xu ly
     * processing_status = 3 huy xu ly
     * processing_status = 4 thanh cong
     * payment_method_id = 1 thanh toan khi nhan hang
     * payment_method_id = 2,3 cac hinh thuc thanh toan
     * payment_status = 1 da thanh toan
     * payment_status = 2 chua thanh toan
     */
    public function store(CreateOrderController $request)
    {
        try {
            $data = $request->only([
                'address',
                'note',
                'payment_method_id',
                'coupon_id',
                'delivery_time'
            ]);
            $products = ($request->products);
            $data['customer_id'] = 3;
            $data['processing_status'] = Order::STATUS_PROCESSING;
            $data['payment_status'] = ($data['payment_method_id'] != Order::PAYMENT_ON_DELIVERY) ? Order::STATUS_PAYED : Order::STATUS_NOT_PAYED;
            $order = Order::create($data);

            foreach ($products as $product) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' =>$product['id'],
                    'quantity' => $product['quantity']
                ]);
            }
            $order->load('orderdetails');
            return $this->successResponse($order, Response::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Occour error when insert order.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $order = Order::with(['user','payment','coupon','orderDetails.product:id,name,price'])->findOrFail($id);
            return $this->successResponse($order, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Order not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Occour error when show Order.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderController $request, Order $order)
    {
        try {
//            $user = Auth::user();
//            if ($user->id == $order->user_id) {
                if ($order->processing_status == Order::STATUS_PROCESSING) {
                    $order->update(['processing_status' => Order::CANCEL_STATUS_PROCESSING]);
                    if($order->processing_status !=Order::CANCEL_STATUS_PROCESSING){
                        $order->address = $request->address;
                        $order->note = $request->note;
                    }
                    $order->save();
//                    return $this->showOne($order, Response::HTTP_OK);
                }
//            }
            return $this->successResponse("Update order successfully", Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->errorResponse("Occour error when show Order.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        try {
            $order->orderDetails()->delete();
            $order->delete();
            return $this->successResponse("Delete order successfully", Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Order not found.", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Occour error when show order.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
