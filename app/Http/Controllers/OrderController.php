<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function getMenusByOrderId($orderId)
    {
        $menus = DB::table("order_details")
                    ->join("menu_items","menu_item_id","=","item_id")
                    ->select("item_name", "category", "price")
                    ->where("order_id", $orderId)
                    ->get();

        return $menus;
    }

    function getOrdersByDate($date)
    {
        $orders = DB::table("order_details")
                ->join("menu_items","menu_item_id","=","item_id")
                ->where("order_date", $date)
                ->orderBy("order_time","desc")
                ->get();
        return $orders;
    }

    function getTotalOrdersByDate($date)
    {
        // $total = DB::select("SELECT sum(price) as total
        //                      from order_details
        //                      join menu_items on item_id = menu_item_id
        //                      WHERE order_date = '2023.01.01';");

        $total = DB::table("order_details")
                    ->join("menu_items","menu_item_id","=","item_id")
                    ->select(DB::raw("sum(price) as total"))
                    ->where("order_date", $date)
                    ->get();

        return $total;
    }
}
