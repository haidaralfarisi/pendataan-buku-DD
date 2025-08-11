<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\OrderList;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = OrderList::paginate(10);
        return view('superadmin.orders.index', compact('orders'));
    }
}
