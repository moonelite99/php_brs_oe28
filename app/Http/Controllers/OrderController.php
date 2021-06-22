<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::user()->id)->orderByDesc('created_at')->paginate(config('default.order_paginate'));

        return view('history.orders', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        if (Gate::allows('make-request', $request)) {
            $order = Order::create([
                'user_id' => $request->user_id,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);

            $cartItems = CartItem::where('user_id', Auth::user()->id)->get();
            foreach ($cartItems as $item) {
                $order->books()->syncWithoutDetaching([$item->book->id => ['quantity' => $item->quantity]]);
                $item->delete();
            }


        } else {
            return redirect()->back();
        }

        return redirect()->route('order_history');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
