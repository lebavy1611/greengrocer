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
use App\Models\Coupon;
use App\Models\Product;

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
            $user = accountLogin();
            $order = Order::with(['user', 'coupon:id,code,percents', 'processStatus:id,name', 'orderDetails.product', 'paymentMethod:id,name'])
                ->where('customer_id', $user->id)->orderBy('created_at', 'desc')->paginate(config('paginate.number_orders'));
            return $this->formatPaginate($order);
        } catch (Exception $ex) {
            return $this->errorResponse("Có lỗi khi hiện danh sách order", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * processing_status = 1 Dang xu ly
     * processing_status = 11 Da xu ly
     * processing_status = 21 huy xu ly
     * processing_status = 31 thanh cong
     * payment_method_id = 1 thanh toan khi nhan hang
     * payment_method_id = 2,3 cac hinh thuc thanh toan
     * payment_status = 1 da thanh toan
     * payment_status = 2 chua thanh toan
     */
    public function store(CreateOrderRequest $request)
    {
        try {
            $user = accountLogin();
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
            $data['customer_id'] = $user->id;
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
            return $this->errorResponse("Có lỗi xảy ra", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            accountLogin();
            $order = Order::with(['user', 'coupon:id,code,percents', 'processStatus:id,name', 'orderDetails.product', 'paymentMethod:id,name'])->findOrFail($id);
            return $this->successResponse($order, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {
            return $this->errorResponse("Không có đơn hành cần tìm", Response::HTTP_NOT_FOUND);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Có lỗi xảy ra", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel(int $orderId)
    {
        try {
            $user = accountLogin();
            $order = Order::find($orderId);
            if ($user->id == $order->customer_id) {
                if ($order->processing_status == Order::STATUS_PROCESSING) {
                    $order->update(['processing_status' => Order::CANCEL_STATUS_PROCESSING]);
                }
            } else {
                return $this->errorResponse("Có lỗi xảy ra", Response::HTTP_INTERNAL_SERVER_ERROR);
            }
            return $this->successResponse("Chỉnh sửa đơn hàng thành công", Response::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Có lỗi xảy ra", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            accountLogin();
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

    public function add(CreateOrderRequest $request)
    {
        try {
            $user = accountLogin();
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
            $data['customer_id'] = $user->id;
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
            if (!empty($data['coupon_id'])) Coupon::where('id', $data['coupon_id'])->decrement('times');
            $order->load('orderdetails');
            return $this->successResponse($order, Response::HTTP_OK);
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Có lỗi xảy ra", Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
