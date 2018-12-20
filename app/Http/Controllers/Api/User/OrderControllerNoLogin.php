<?php

namespace App\Http\Controllers\Api\User;


use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\User\CreateOrderRequest;
use App\Http\Requests\User\UpdateOrderRequest;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;

class OrderControllerNoLogin extends ApiController
{
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
    public function store(CreateOrderRequest $request)
    {
        try {
            $data = $request->only([
                'full_name',
                'phone',
                'address',
                'note',
                'payment_method_id',
                'coupon_id',
                'delivery_time'
            ]);
            $products = ($request->products);
            $data['code'] = getCodeOrder(8);
            $data['customer_id'] = null;
            $data['processing_status'] = Order::STATUS_PROCESSING;
            $data['payment_status'] = ($data['payment_method_id'] != Order::PAYMENT_ON_DELIVERY) ? Order::STATUS_PAYED : Order::STATUS_NOT_PAYED;
            $order = Order::create($data);

            foreach ($products as $product) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' =>$product['id'],
                    'quantity' => $product['quantity'],
                    'price' => Product::find($product['id'])->price
                ]);
            }
            if (!empty($data['coupon_id'])) Coupon::where('id', $data['coupon_id'])->decrement('times');
            $order->load('orderdetails');
            return $this->successResponse($order, Response::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Occour error when insert order.", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
