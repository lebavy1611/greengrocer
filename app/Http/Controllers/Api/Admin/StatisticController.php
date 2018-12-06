<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
use App\Factories\StatisticFactory;
use Illuminate\Http\Response;
use App\Models\Order;
use Carbon\Carbon;

class StatisticController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $statisticManager = StatisticFactory::build('Manager');
        $statisticUser = StatisticFactory::build('User');
        $statisticCategory = StatisticFactory::build('Category');
        $statisticShop = StatisticFactory::build('Shop');
        $statisticProduct = StatisticFactory::build('Product');
        $statisticOrder = StatisticFactory::build('Order');


        $data['managers'] = $statisticManager->count();
        $data['users'] = $statisticUser->count();
        $data['categories'] = $statisticCategory->count();
        $data['shops'] = $statisticShop->count();
        $data['porducts'] = $statisticProduct->count();
        $data['orders'] = $statisticOrder->count();

        $fromWeek = Carbon::today()->subWeek()->startOfWeek();
        $toWeek = Carbon::today()->subWeek()->endOfWeek();
        $fromMonth = Carbon::today()->subMonth()->startOfMonth();
        $toMonth = Carbon::today()->subMonth()->endOfMonth();
        $fromYear = Carbon::today()->subYear()->startOfYear();
        $toYear = Carbon::today()->subYear()->endOfYear();
        $data['orders_statistic'] = [
            'today' => Order::whereDate('created_at', Carbon::today())->count(),
            'yesterday' => Order::whereDate('created_at', Carbon::yesterday())->count(),
            'lastweek' => Order::whereBetween('created_at', [$fromWeek, $toWeek])->count(),
            'lastmonth' => Order::whereBetween('created_at', [$fromMonth, $toMonth])->count(),
            'lastyear' => Order::whereBetween('created_at', [$fromYear, $toYear])->count(),
        ];
        return $this->successResponse($data, Response::HTTP_OK);
    }

}
