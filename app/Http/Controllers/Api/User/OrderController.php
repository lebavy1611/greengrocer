<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreateOrderController;
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
            $user_id = 3;
            $order = Order::with(['user','payment','coupon'])->where('customer_id', $user_id)->orderBy('created_at', 'desc')->paginate(config('paginate.number_orders'));
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
     * payment_method_id = 1 thanh toan khi nhan hang
     * payment_method_id = 2,3 cac hinh thuc thanh toan
     * payment_status = 1 da thanh toan
     * payment_status = 2 chua thanh toan
     */
    public function store(CreateOrderController $request)
    {
        try {
            $data = $request->only([
                'customer_id',
                'address',
                'note',
                'payment_method_id',
                'coupon_id',
                'delivery_time'
            ]);
            $products = ($request->products);
            $data['processing_status'] = Order::STATUS_NOT_PROCESSING;
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
            if ($order->processing_status == 0) {
                $order->processing_status = $request->processing_status;
            }
            $order->address = $request->address;
            $order->note = $request->note;
            $order->payment_status = $request->payment_status;
            $order->delivery_time = $request->delivery_time;
            $order->save();

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
