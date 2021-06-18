@extends('layouts.app')

@section('content')
    <section class="padding-bottom-18">
        <div class="section-heading3 heading-dark">
            <h2 class="item-heading">{{ trans('msg.fav_book') }}</h2>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($books as $book)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="product-box-layout1">
                            <figure class="item-figure"><a href="{{ route('show_book', $book->id) }}"><img
                                        src="{{ asset($book->img_path) }}" alt="{{ trans('msg.book') }}"></a>
                            </figure>
                            <div class="item-content">
                                <h3 class="item-title"><a href="#">{{ $book->title }}</a></h3>
                                @if ($book->rating != config('default.rating'))
                                    <ul class="item-rating">
                                        @for ($i = 0; $i < round($book->rating); $i++)
                                            <li class="star-fill"><i class="fas fa-star"></i></li>
                                        @endfor
                                        @for ($i = 0; $i < config('default.max_rating') - round($book->rating); $i++)
                                            <li class="star-empty"><i class="fas fa-star"></i></li>
                                        @endfor
                                        <li>
                                            <span>{{ $book->rating }}
                                                <span>
                                                    &#47; {{ config('default.max_rating') }}
                                                </span>
                                            </span>
                                        </li>
                                    </ul>
                                @endif
                                <ul class="entry-meta">
                                    <li>
                                        <i class="fas fa-book cirilla-color"></i>
                                        {{ $book->pages_number . ' ' . trans('msg.pages') }}
                                    </li>
                                    <li><i class="fas fa-user cirilla-color"></i> <span>{{ $book->author }}</span></li>
                                </ul>
                                <ul class="entry-meta">
                                    <li><i class="fa fa-credit-card cirilla-color" aria-hidden="true"></i> <span class="book-price">{{ $book->price }}</span></li>
                                    {{-- <li><a href="#"><i class="fa fa-cart-plus" aria-hidden="true"></i> <span>{{ trans('msg.add_to_cart') }}</span></a></li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pad-link">{{ $books->links() }}</div>
        </div>
    </section>
@endsection
