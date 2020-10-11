@extends('layouts.app')

@section('content')
    <section class="padding-bottom-18">
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
                                        <a href="#">
                                            <i class="fas fa-book"></i>
                                            {{ $book->pages_number . ' ' . trans('msg.pages') }}
                                        </a>
                                    </li>
                                    <li><a href="#"><i class="fas fa-user"></i> <span>{{ $book->author }}</span></a></li>
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
