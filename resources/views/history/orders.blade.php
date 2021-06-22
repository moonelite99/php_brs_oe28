@extends('layouts.app')

@section('content')
    <div class="row col-12 wrap-offset">
        <h2 class="title-1 pad-title title-offset">
            {{ trans('msg.order_history') }}
        </h2>
        @if ($orders->count() == 0)
                <p class="margin-left-30">{{ trans('msg.no_order') }}</p>
        @else
            @foreach ($orders as $key => $order)
                <div class="flex-wrap">
                    <div class="col-lg-8 pad-table">
                        <div class="table-responsive table--no-card m-b-30">
                            <table class="table table-borderless table-striped table-earning">
                                <thead>
                                    <tr>
                                        <th class="cart-image"></th>
                                        <th class="cart-title-header">{{ trans('msg.product') }}</th>
                                        <th class="cart-price-header">{{ trans('msg.price') }}</th>
                                        <th class="cart-quantity-header">{{ trans('msg.amount') }}</th>
                                        <th>{{ trans('msg.subtotal') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->books as $item)
                                        <tr class="table-row">
                                            <td class="cart-image">
                                                <a href="{{ route('show_book', $item->id) }}">
                                                    <img class="cart-item-image" src="{{ asset($item->img_path) }}"
                                                        alt="{{ trans('msg.book') }}">
                                                </a>
                                            </td>
                                            <td>
                                                <p class="cart-title">
                                                    {{ $item->title }}
                                                </p>
                                            </td>
                                            <td class="book-price cart-price item-price">
                                                {{ $item->price }}
                                            </td>
                                            <td class="cart-quantity">
                                                <p class="item-quantity" value={{ $item->pivot->quantity }}>
                                                    {{ $item->pivot->quantity }}</p>
                                                <a data-url="{{ route('cartItem.update', $item->id) }}"
                                                    class="btn btn-primary update-btn confirm-update" href="#"
                                                    role="button"><i class="fa fa-check" aria-hidden="true"></i></a>
                                            </td>
                                            <td class="book-price subtotal">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="order-info-wrap col-lg-4">
                        @if ($key == 0)
                            <h2 class="black order-info-title">Thông tin đặt hàng</h2>
                        @endif
                        <div class="inner-order">
                            <p class="cart-input">Số điện thoại</p>
                            <p class="black">{{ $order->phone }}</p>
                            <p class="cart-input">Địa chỉ nhận hàng</p>
                            <p class="black">{{ $order->address }}</p>
                            <p class="cart-input">Tổng tiền hàng</p>
                            <p id="cart-total" class="black cart-input total-value"></p>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-8"><div class="pull-right">{{ $orders->links() }}</div></div>
        @endif
    </div>
    </div>
@endsection
