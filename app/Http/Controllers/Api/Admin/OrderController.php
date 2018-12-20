<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\CreateOrderController;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;

class OrderController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $perPage = $request->perpage ? $request->perpage : config('paginate.number_orders');
        try {
            $orders = Order::with(['user','coupon:id,code,percents', 'processStatus:id,name', 'paymentMethod:id,name', 'orderDetails.product'])
                ->orderFilter($request)->orderBy('created_at', 'desc')->get();
            $data = $orders->toArray();
            array_walk($data, function(&$order, $key) {
                $total = 0;
                $orderDetails = collect($order['order_details']);
                foreach ($orderDetails as $key => $orderDetail) {
                    $total += $orderDetail['price'] * $orderDetail['quantity'];
                }
                $order['total_money'] = $total;
                unset($order['order_details']);
            });
            return $this->paginate(collect($data));
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return $this->errorResponse("Orders can not be show.", Response::HTTP_INTERNAL_SERVER_ERROR);
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
            $manager = accountLogin();
            $order = Order::with(['user', 'coupon', 'processStatus:id,name', 'orderDetails.product', 'paymentMethod:id,name'])->findOrFail($id);
            $total = 0;
            $orderDetails = $order['orderDetails'];
            foreach ($orderDetails as $key => $orderDetail) {
                if (isProviderLogin()) {
                    if (Product::find($orderDetail->product_id)->shop->manager_id != $manager->id) {
                        $orderDetails->forget($key);
                    } else {
                        $total += $orderDetail->price * $orderDetail->quantity;
                    }
                } else {
                    $total += $orderDetail->price * $orderDetail->quantity;                        
                }
            }
            $order['total_money'] = $total;
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
    public function update(UpdateOrderRequest $request, Order $order)
    {
        try {
            if ($order->processing_status == Order::STATUS_PROCESSING) {
                $order->processing_status = $request->processing_status;
            }
            $order->payment_status = $request->payment_status;
//            $order->delivery_time = $request->delivery_time;
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
