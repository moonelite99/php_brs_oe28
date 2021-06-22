@extends('layouts.app')

@section('content')
    <div class="row col-12 wrap-offset">
        <h2 class="title-1 pad-title title-offset">
            {{ trans('msg.your_cart') }}
        </h2>
        <div class="flex-wrap">
            <div class="col-lg-8 pad-table">
                @if ($cartItems->count() == 0)
                <p class="margin-left-20">{{ trans('msg.no_product') }}</p>
                @else
                <div class="table-responsive table--no-card m-b-30">
                    <table class="table table-borderless table-striped table-earning">
                        <thead>
                            <tr>
                                <th class="cart-image"></th>
                                <th class="cart-title-header">{{ trans('msg.product') }}</th>
                                <th class="cart-price-header">{{ trans('msg.price') }}</th>
                                <th class="cart-quantity-header">{{ trans('msg.amount') }}</th>
                                <th>{{ trans('msg.subtotal') }}</th>
                                <th class="cart-delete-header">{{ trans('msg.delete') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartItems as $cartItem)
                                <tr class="table-row">
                                    <td class="cart-image">
                                        <a href="{{ route('show_book', $cartItem->book_id) }}">
                                            <img class="cart-item-image" src="{{ asset($cartItem->book->img_path) }}"
                                                alt="{{ trans('msg.book') }}">
                                        </a>
                                    </td>
                                    <td>
                                        <p class="cart-title">
                                            {{ $cartItem->book->title }}
                                        </p>
                                    </td>
                                    <td class="book-price cart-price item-price">
                                        {{ $cartItem->book->price }}
                                    </td>
                                    <td class="cart-quantity">
                                        <input class="cart-quantity item-quantity" data-id={{ $cartItem->id }}
                                            type="number" name="quantity" id="quantity"
                                            value="{{ $cartItem->quantity }}">
                                        <a data-url="{{ route('cartItem.update', $cartItem->id) }}"
                                            class="btn btn-primary update-btn confirm-update" href="#" role="button"><i
                                                class="fa fa-check" aria-hidden="true"></i></a>
                                    </td>
                                    <td class="book-price subtotal">
                                    </td>
                                    <td class="cart-delete">
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#exampleModal{{ $cartItem->id }}">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                        <div class="modal fade" id="exampleModal{{ $cartItem->id }}" tabindex="-1"
                                            role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">
                                                            {{ trans('msg.delete') }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                            aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{ trans('msg.delete_confirm') }}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post"
                                                            action="{{ route('cartItem.destroy', $cartItem->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div>
                                                                <button class="btn btn-danger confirm-delete"
                                                                    data-dismiss="modal"
                                                                    data-url="{{ route('cartItem.destroy', $cartItem->id) }}">
                                                                    {{ trans('msg.delete') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('msg.close') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <div class="pull-right">{{ $reviews->links() }}</div> --}}
            </div>
            <div class="order-wrap col-lg-4">
                <form method="POST" action="{{ route('order.store') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    <h2 class="black">Thông tin đặt hàng</h2>
                    <div class="inner-order">
                        <p class="cart-input">Số điện thoại</p>
                        <input name="phone" type="text" pattern="((09|03|07|08|05)+([0-9]{8})\b)" required>
                        <p class="cart-input">Địa chỉ nhận hàng</p>
                        <textarea name="address" class="cart-address" required></textarea>
                        <p class="cart-input">Tổng tiền hàng</p>
                        <div class="flex-wrap">
                            <p id="cart-total" class="black cart-input total-value"></p>
                            <button type="submit" class="btn btn-primary">Đặt hàng</button>
                        </div>
                </form>
            </div>
            @endif
        </div>
    </div>
    </div>
@endsection
