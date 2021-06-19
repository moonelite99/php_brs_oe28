@extends('layouts.app')

@section('content')
    <div class="row col-10 offset-1">
        <h2 class="title-1 pad-title">
            {{ trans('msg.written_review') }}
        </h2>
        <div class="col-lg-12 pad-table">
            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th class="cart-image"></th>
                            <th class="cart-title-header">{{ trans('msg.title') }}</th>
                            <th class="cart-price-header">{{ trans('msg.price') }}</th>
                            <th class="cart-quantity-header">{{ trans('msg.amount') }}</th>
                            <th>{{ trans('msg.subtotal') }}</th>
                            <th>{{ trans('msg.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $cartItem)
                            <tr>
                                <td class="cart-image">
                                    <img class="cart-item-image" src="{{ asset($cartItem->book->img_path) }}" alt="{{ trans('msg.book') }}">
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
                                    <input class="cart-quantity item-quantity" type="number" name="quantity" id="quantity" value="{{ $cartItem->quantity }}">
                                </td>
                                <td class="book-price subtotal">

                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#exampleModal{{ $cartItem->id }}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="exampleModal{{ $cartItem->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ trans('msg.delete') }}
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
                                                            <button type="submit" class="btn btn-danger"
                                                                onclick="">{{ trans('msg.delete') }}</button>
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
    </div>
@endsection
