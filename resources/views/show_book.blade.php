@extends('layouts.app')

@section('content')
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <section class="single-recipe-wrap-layout1 padding-bottom-50">
        <div class="container">
            <div class="row gutters-60">
                <div class="col-lg-8">
                    <div class="single-recipe-layout1">
                        <h2 class="item-title">{{ $book->title }}</h2>
                        <div class="row mb-4">
                            <div class="col-xl-12 col-12">
                                <ul class="entry-meta">
                                    <li class="single-meta">
                                        <a href="#">
                                            <i class="fas fa-user"></i>
                                            <span>{{ $book->author }}</span>
                                        </a>
                                    </li>
                                    {{-- <li class="single-meta">
                                        <a href="#">
                                            <i class="fas fa-book"></i>
                                            {{ $book->pages_number . ' ' . trans('msg.pages') }}
                                        </a>
                                    </li> --}}
                                    {{-- <li class="single-meta">
                                        <a href="#">
                                            <i class="far fa-calendar-alt"></i>
                                            {{ $book->publish_date }}
                                        </a>
                                    </li> --}}
                                    <li class="single-meta">
                                        @if ($book->rating != config('default.rating'))
                                            <ul class="item-rating">
                                                @for ($i = 0; $i < round($book->rating); $i++)
                                                    <li class="star-fill"><i class="fas fa-star"></i></li>
                                                @endfor
                                                @for ($i = 0; $i < config('default.max_rating') - round($book->rating); $i++)
                                                    <li class="star-empty"><i class="fas fa-star"></i></li>
                                                @endfor
                                                {{-- <li>
                                                    <span>{{ $book->rating }}
                                                        <span>
                                                            &#47; {{ config('default.max_rating') }}
                                                        </span>
                                                    </span>
                                                </li> --}}
                                            </ul>
                                        @endif
                                    </li>

                                    <div class="pull-right">
                                        <input type="hidden" id="user_id" value="{{ Auth::user()->id }}">
                                        <input type="hidden" id="book_id" value="{{ $book->id }}">
                                        <li class="single-meta">
                                            <a href="#">
                                                    <i data-toggle="tooltip" data-placement="top" data-html="true" title="<p class='fs-13'>{{ trans('msg.cancel_mark_as_reading') }}</p>" class="fas fa-bookmark bookmark  @if ($status == config('read.unread') || $status == config('read.read')) d-none @endif" data-status="{{ config('read.unread') }}" id="reading"></i>
                                                    <i data-toggle="tooltip" data-placement="top" data-html="true" title="<p class='fs-13'>{{ trans('msg.mark_as_reading') }}</p>" class="far fa-bookmark bookmark @if ($status == config('read.reading')) d-none @endif" data-status="{{ config('read.reading') }}" id="unreading"></i>
                                            </a>
                                        </li>
                                        <li class="single-meta">
                                            <a href="#">
                                                    <i data-toggle="tooltip" data-placement="top" data-html="true" title="<p class='fs-13'>{{ trans('msg.cancel_mark_as_read') }}</p>" class="fas fa-check-circle bookmark @if ($status == config('read.unread') || $status == config('read.reading')) d-none @endif" data-status="{{ config('read.unread') }}" id="read"></i>
                                                    <i data-toggle="tooltip" data-placement="top" data-html="true" title="<p class='fs-13'>{{ trans('msg.mark_as_read') }}</p>" class="far fa-check-circle bookmark @if ($status == config('read.read')) d-none @endif" data-status="{{ config('read.read') }}" id="unread"></i>
                                            </a>
                                        </li>
                                        <li class="single-meta">
                                            <a href="#">
                                                    <i data-toggle="tooltip" data-placement="top" data-html="true" title="<p class='fs-13'>{{ trans('msg.cancel_mark_as_fav') }}</p>" class="fas fa-heart bookmark @if ($favorite == config('default.not_fav')) d-none @endif" data-favorite="{{ config('read.unread') }}" id="fav"></i>
                                                    <i data-toggle="tooltip" data-placement="top" data-html="true" title="<p class='fs-13'>{{ trans('msg.mark_as_fav') }}</p>" class="far fa-heart bookmark @if ($favorite == config('default.fav')) d-none @endif" data-favorite="{{ config('default.fav') }}" id="unfav"></i>
                                            </a>
                                        </li>
                                    </div>
                                    <li class="single-meta pull-right add-to-cart">
                                        <a href="#" id="add-to-cart">
                                            <i class="fa fa-cart-plus fs-20" aria-hidden="true"></i> <span class="fs-16">{{ trans('msg.add_to_cart') }}</span>
                                        </a>
                                        <form id="cart-form" action="{{ route('cartItem.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" id="add-to-cart-url" value="{{ route('cartItem.store') }}">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        </form>
                                    </li>
                                    <li class="single-meta pull-right"><i class="fa fa-credit-card cirilla-color" aria-hidden="true"></i> <span class="book-price">{{ $book->price }}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="item-figure">
                            <img class="single-book" src="{{ asset($book->img_path) }}" alt="{{ trans('msg.book') }}">
                        </div>
                        <ul class="nav nav-tabs margin-top-30" id="myTab" role="tablist">
                            <li class="nav-item col-6">
                                <a class="nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-selected="true"><h4 class="text-center">{{ trans('msg.description') }}</h4></a>
                            </li>
                            <li class="nav-item col-6">
                                <a class="nav-link active" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-selected="false"><h4 class="text-center">{{ trans('msg.review') }}</h4></a>
                            </li>
                        </ul>
                        <div class="tab-content pl-3 p-1" id="myTabContent">
                            <div class="tab-pane fade" id="description" role="tabpanel">
                                <p class="item-description">{{ $book->description }}</p>
                            </div>
                            <div class="tab-pane fade show active" id="review" role="tabpanel">
                                <ul class="nav nav-tabs margin-top-30" id="myTab" role="tablist">
                                    <li class="nav-item col-4">
                                        <a class="nav-link" id="cirilla-tab" data-toggle="tab" href="#cirilla" role="tab" aria-selected="true"><h4 class="text-center cirilla-color">Cirilla</h4></a>
                                    </li>
                                    <li class="nav-item col-4">
                                        <a class="nav-link active" id="tiki-tab" data-toggle="tab" href="#tiki" role="tab" aria-selected="true"><h4 class="text-center tiki-color">Tiki</h4></a>
                                    </li>
                                    <li class="nav-item col-4">
                                        <a class="nav-link" id="shopee-tab" data-toggle="tab" href="#shopee" role="tab" aria-selected="false"><h4 class="text-center shopee-color">Shopee</h4></a>
                                    </li>
                                </ul>
                                <div class="tab-content pl-3 p-1" id="myTabContent2">
                                    <div class="tab-pane fade" id="cirilla" role="tabpanel">
                                        <div class="recipe-reviews">
                                            <div class="section-heading heading-dark">
                                                <h2 class="item-heading">{{ trans('msg.book_reviews') }}</h2>
                                            </div>
                                            <div class="avarage-rating-wrap">
                                                @if ($book->rating != config('default.rating'))
                                                <div class="avarage-rating">{{ trans('msg.avg_rating') }}
                                                    <span class="rating-icon-wrap">
                                                        @for ($i = 0; $i < round($book->rating); $i++)
                                                            <i class="fas fa-star"></i>
                                                        @endfor
                                                        @for ($i = 0; $i < config('default.max_rating') - round($book->rating); $i++)
                                                            <i class="far fa-star"></i>
                                                        @endfor
                                                    </span>
                                                    <span class="rating-number">({{ $book->rating }})</span>
                                                </div>
                                                <div class="total-reviews">{{ trans('msg.total_reviews') }}<span class="review-number">({{ $reviews->count() }})</span></div>
                                                @endif
                                            </div>
                                            <ul>
                                                @foreach ($reviews as $review)
                                                    <li class="reviews-single-item">
                                                        <div class="media media-none--xs">
                                                            <div class="media-body">
                                                                <h4 class="comment-title">{{ $review->user()->first()->name }}</h4>
                                                                <span class="post-date">{{ $review->updated_at }}</span>
                                                                <div class="ellipsis">{{ ($review->title) }}</div>
                                                                <ul class="item-rating">
                                                                    @for ($i = 0; $i < round($book->users()->firstWhere('user_id', $review->user_id)->pivot->rating); $i++)
                                                                        <i class="fas fa-star star"></i>
                                                                    @endfor
                                                                    @for ($i = 0; $i < config('default.max_rating') - round($book->users()->firstWhere('user_id', $review->user_id)->pivot->rating); $i++)
                                                                        <i class="far fa-star star"></i>
                                                                    @endfor
                                                                </ul>
                                                                <a href="{{ route('reviews.show', $review->id) }}" class="item-btn">{{ trans('msg.read_more') }}<i class="fas fa-long-arrow-alt-right"></i></a>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade show active" id="tiki" role="tabpanel">
                                        <div class="recipe-reviews">
                                            <div class="section-heading heading-dark">
                                                <h2 class="item-heading">{{ trans('msg.book_reviews') }}</h2>
                                            </div>
                                            <ul>
                                                @foreach ($tikiReviews as $review)
                                                    <li class="reviews-single-item">
                                                        <div class="media media-none--xs">
                                                            <div class="media-body">
                                                                <h4 class="comment-title">{{ $review->username }}</h4>
                                                                <span class="post-date">{{ $review->reviewed_at }}</span>
                                                                <div class="ellipsis2 bold">{{ ($review->title) }}</div>
                                                                <div class="tiki-comment">{{ $review->content }}</div>
                                                                <ul class="item-rating">
                                                                    @for ($i = 0; $i < $review->rating; $i++)
                                                                        <i class="fas fa-star star"></i>
                                                                    @endfor
                                                                    @for ($i = 0; $i < config('default.max_rating') - $review->rating; $i++)
                                                                        <i class="far fa-star star"></i>
                                                                    @endfor
                                                                </ul>
                                                                @if (Auth::user()->role == config('role.admin'))
                                                                    <form id="tiki{{ $review->id }}" method="post" action="{{ route('shopReview.destroy', $review->id) }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <a href="#" onclick="event.preventDefault(); $('#tiki{{ $review->id }}').submit()"  class="item-btn"><i class="fas fa-times"></i></a>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="shopee" role="tabpanel">
                                        <div class="recipe-reviews">
                                            <div class="section-heading heading-dark">
                                                <h2 class="item-heading">{{ trans('msg.book_reviews') }}</h2>
                                            </div>
                                            <ul>
                                                @foreach ($shopeeReviews as $review)
                                                    <li class="reviews-single-item">
                                                        <div class="media media-none--xs">
                                                            <div class="media-body">
                                                                <h4 class="comment-title">{{ $review->username }}</h4>
                                                                <span class="post-date">{{ $review->reviewed_at }}</span>
                                                                <div class="tiki-comment">{{ $review->content }}</div>
                                                                <ul class="item-rating">
                                                                    @for ($i = 0; $i < $review->rating; $i++)
                                                                        <i class="fas fa-star star"></i>
                                                                    @endfor
                                                                    @for ($i = 0; $i < config('default.max_rating') - $review->rating; $i++)
                                                                        <i class="far fa-star star"></i>
                                                                    @endfor
                                                                </ul>
                                                                @if (Auth::user()->role == config('role.admin'))
                                                                    <form id="shopee{{ $review->id }}" method="post" action="{{ route('shopReview.destroy', $review->id) }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <a href="#" onclick="event.preventDefault(); $('#shopee{{ $review->id }}').submit()"  class="item-btn"><i class="fas fa-times"></i></a>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tag-share">
                            <ul>
                                <li>
                                    <ul class="inner-tag">
                                        @foreach ($selectedCategories as $category)
                                            <li>
                                                <a href="{{ route('categorized_book', $category->id) }}">{{ trans('msg.' . $category->name) }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="leave-review">
                            <div class="section-heading heading-dark">
                                <h2 class="item-heading">{{ trans('msg.leave_review') }}</h2>
                            </div>
                            @if ($reviewed != null)
                                <form class="leave-form-box" method="POST" action="{{ route('reviews.update', $reviewed->id) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="rate-wrapper col-11">
                                            <div class="rate-label">{{ trans('msg.rating') }}</div>
                                            <div class="rate selected">
                                                <div class="rate-item @if ($rated == 1) active @endif" id="rate-1">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                                <div class="rate-item @if ($rated == 2) active @endif" id="rate-2">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                                <div class="rate-item @if ($rated == 3) active @endif" id="rate-3">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                                <div class="rate-item @if ($rated == 4) active @endif" id="rate-4">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                                <div class="rate-item @if ($rated == 5) active @endif" id="rate-5">
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                data-target="#exampleModal{{ $reviewed->id }}">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 form-group">
                                            <label>{{ trans('msg.title') }}</label>
                                            <input class="col-12" type="text" name="title" value="{{ $reviewed->title }}" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label>{{ trans('msg.content') }}</label>
                                            <textarea name="content">{{ $reviewed->content }}</textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <input type="hidden" placeholder="" class="form-control width-100" name="user_id"
                                            required value="{{ Auth::user()->id }}">
                                        <input type="hidden" placeholder="" class="form-control width-100" name="book_id"
                                            required value="{{ $book->id }}">
                                        <input type="hidden" placeholder="" class="form-control width-100" name="rating"
                                            id="rating" value="{{ $rated }}" required>
                                        <div class="col-12 form-group mb-0">
                                            <button type="submit" class="item-btn">{{ trans('msg.submit') }}</button>
                                        </div>
                                    </div>
                                    <div class="form-response"></div>
                                </form>
                                <div class="modal fade" id="exampleModal{{ $reviewed->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{ trans('msg.review_about') . $book->title }}</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                {{ trans('msg.delete_confirm') }}
                                            </div>
                                            <div class="modal-footer">
                                                <form method="post" action="{{ route('reviews.destroy', $reviewed->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div>
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="">{{ trans('msg.delete') }}</button>
                                                    </div>
                                                </form>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <form class="leave-form-box" method="POST" action="{{ route('reviews.store') }}">
                                    @csrf
                                    <div class="rate-wrapper">
                                        <div class="rate-label">{{ trans('msg.rating') }}</div>
                                        <div class="rate">
                                            <div class="rate-item" id="rate-1">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                            <div class="rate-item" id="rate-2">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                            <div class="rate-item" id="rate-3">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                            <div class="rate-item" id="rate-4">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                            <div class="rate-item" id="rate-5">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 form-group">
                                            <label>{{ trans('msg.title') }}</label>
                                            <input class="col-12" type="text" name="title" required>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <div class="col-12 form-group">
                                            <label>{{ trans('msg.content') }}</label>
                                            <textarea name="content"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                        <input type="hidden" placeholder="" class="form-control width-100" name="user_id"
                                            required value="{{ Auth::user()->id }}">
                                        <input type="hidden" placeholder="" class="form-control width-100" name="book_id"
                                            required value="{{ $book->id }}">
                                        <input type="hidden" placeholder="" class="form-control width-100" name="rating"
                                            id="rating" value="{{ $rated }}" required>
                                        <div class="col-12 form-group mb-0">
                                            <button type="submit" class="item-btn">{{ trans('msg.submit') }}</button>
                                        </div>
                                    </div>
                                    <div class="form-response"></div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 sidebar-widget-area sidebar-break-md">
                    <div class="widget">
                        <div class="section-heading heading-dark">
                            <h3 class="item-heading">{{ trans('msg.lastest_books') }}</h3>
                        </div>
                        <div class="widget-latest">
                            <ul class="block-list">
                                @foreach ($lastestBook as $book)
                                    <li class="single-item">
                                        <div class="item-img">
                                            <a href="{{ route('show_book', $book->id) }}">
                                                <img class="img-100" src="{{ asset($book->img_path) }}">
                                            </a>
                                        </div>
                                        <div class="item-content">
                                            <h4 class="item-title">
                                                <a href="{{ route('show_book', $book->id) }}">{{ $book->title }}</a>
                                            </h4>
                                            <div class="item-post-by">
                                                <a href="single-blog.html">
                                                    <i class="fas fa-user"></i>
                                                    {{ $book->author }}
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="widget">
                        <div class="section-heading heading-dark">
                            <h3 class="item-heading">{{ trans('msg.may_like') }}</h3>
                        </div>
                        <div class="widget-featured-feed">
                            <div class="rc-carousel nav-control-layout1" data-loop="true"
                                data-items="{{ config('book.suggest_num') }}" data-autoplay="true"
                                data-autoplay-timeout="5000" data-smart-speed="700" data-dots="false" data-nav="true"
                                data-nav-speed="false" data-r-x-small="1" data-r-x-small-nav="true"
                                data-r-x-small-dots="false" data-r-x-medium="1" data-r-x-medium-nav="true"
                                data-r-x-medium-dots="false" data-r-small="1" data-r-small-nav="true"
                                data-r-small-dots="false" data-r-medium="1" data-r-medium-nav="true"
                                data-r-medium-dots="false" data-r-large="1" data-r-large-nav="true"
                                data-r-large-dots="false" data-r-extra-large="1" data-r-extra-large-nav="true"
                                data-r-extra-large-dots="false">
                                @foreach ($randomBook as $book)
                                    <div class="featured-box-layout1">
                                        <a href="{{ route('show_book', $book->id) }}">
                                            <div class="item-img">
                                                <img class="img-300" src="{{ asset($book->img_path) }}" class="img-fluid">
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="widget">
                        <div class="section-heading heading-dark">
                            <h3 class="item-heading">{{ trans('msg.category') }}</h3>
                        </div>
                        <div class="widget-categories">
                            <ul>
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('categorized_book', $category->id) }}">{{ trans('msg.' . $category->name) }}
                                            <span>{{ $category->books->count() }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('js/ckedit.js') }}"></script>
    <script src="{{ asset('js/mark.js') }}"></script>
@endsection

