@extends('layouts.app')

@section('content')
    <section class="single-recipe-wrap-layout1 padding-bottom-50">
        <div class="container">
            <div class="row gutters-60">
                <div class="col-lg-8">
                    <div class="single-recipe-layout1">
                        <h2 class="item-title">{{ $book->title }}</h2>
                        <div class="row mb-4">
                            <div class="col-xl-9 col-12">
                                <ul class="entry-meta">
                                    <li class="single-meta">
                                        <a href="#">
                                            <i class="fas fa-user"></i>
                                            <span>{{ $book->author }}</span>
                                        </a>
                                    </li>
                                    <li class="single-meta">
                                        <a href="#">
                                            <i class="fas fa-book"></i>
                                            {{ $book->pages_number . ' ' . trans('msg.pages') }}
                                        </a>
                                    </li>
                                    <li class="single-meta">
                                        <a href="#">
                                            <i class="far fa-calendar-alt"></i>
                                            {{ $book->publish_date }}
                                        </a>
                                    </li>
                                    <li class="single-meta">
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
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="item-figure">
                            <img class="single-book" src="{{ asset($book->img_path) }}" alt="{{ trans('msg.book') }}">
                        </div>
                        <div class="section-heading heading-dark">
                            <h3 class="item-heading">{{ trans('msg.description') }}</h3>
                        </div>
                        <p class="item-description">{{ $book->description }}</p>
                        <div class="tag-share">
                            <ul>
                                <li>
                                    <ul class="inner-tag">
                                        @foreach ($selectedCategories as $category)
                                            <li>
                                                <a href="#">{{ trans('msg.' . $category->name) }}</a>
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
                            <form class="leave-form-box">
                                <div class="rate-wrapper">
                                    <div class="rate-label">{{ trans('msg.rating') }}</div>
                                    <div class="rate">
                                        <div class="rate-item"><i class="fa fa-star" aria-hidden="true"></i></div>
                                        <div class="rate-item"><i class="fa fa-star" aria-hidden="true"></i></div>
                                        <div class="rate-item"><i class="fa fa-star" aria-hidden="true"></i></div>
                                        <div class="rate-item"><i class="fa fa-star" aria-hidden="true"></i></div>
                                        <div class="rate-item"><i class="fa fa-star" aria-hidden="true"></i></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 form-group">
                                        <label>{{ trans('msg.title') }}</label>
                                        <input type="text" placeholder="" class="form-control width-100" name="name"
                                            required>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="col-12 form-group">
                                        <label>{{ trans('msg.content') }}</label>
                                        <textarea placeholder="" class="textarea form-control width-100" name="message"
                                            required></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="col-12 form-group mb-0">
                                        <button type="submit" class="item-btn">{{ trans('msg.submit') }}</button>
                                    </div>
                                </div>
                                <div class="form-response"></div>
                            </form>
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
                                        <a href="#">{{ trans('msg.' . $category->name) }}
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
@endsection
