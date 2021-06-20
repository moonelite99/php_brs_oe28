<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartItems = CartItem::where('user_id', Auth::user()->id)->get();

        return view('cart.index', compact('cartItems'));
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
    public function store(Request $request)
    {
        if (Auth::user()->id == $request->user_id) {
            $cartItems = CartItem::where('user_id', Auth::user()->id)->where('book_id', $request->book_id)->first();
            if ($cartItems === null) {
                CartItem::create([
                    'user_id' => $request->user_id,
                    'book_id' => $request->book_id,
                    'quantity' => $request->quantity,
                ]);
            } else {
                $cartItems->update([
                    'quantity' => $cartItems->quantity + 1,
                ]);
            }
            $data = [
                'msg' => trans('msg.add_to_cart_successfully'),
                'title' => trans('msg.notification'),
            ];
            return $data;
        }

        return null;
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
        try {
            $cartItem = CartItem::findOrFail($id);
            $cartItem->update([
                'quantity' => $request->quantity,
            ]);
        } catch (ModelNotFoundException $e) {
            return null;
        }

        $data = [
            'msg' => trans('msg.update_successful'),
            'title' => trans('msg.notification'),
        ];
        return $data;
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
            $cartItem = CartItem::findOrFail($id);
            $cartItem->delete();
        } catch (ModelNotFoundException $e) {
            return null;
        }
        $data = [
            'msg' => trans('msg.delete_successful'),
            'title' => trans('msg.notification'),
        ];

        return $data;
    }

    public function getItemsAmount()
    {
        $amount = CartItem::where('user_id', Auth::user()->id)->count();

        return $amount;
    }
}
