@extends('layouts.app')

@section('content')
    <script src="{{ asset('js/jquery-3.5.1.js') }}"></script>
    <section class="single-blog-page-wrap padding-top-30 padding-bottom-50">
        <div class="container">
            <div class="row gutters-60">
                <div class="col-lg-8">
                    <div class="single-blog-box">
                        <div class="main-figure">
                            <a href="{{ route('show_book', $book->id) }}"><img class="single-book"
                                    src="{{ asset($book->img_path) }}"></a>
                        </div>
                        <div class="blog-content">
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
                                <li class="single-meta pull-right">
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
                            <h3 class="item-title">
                                <a href="{{ route('reviews.show', $review->id) }}">
                                    {{ $review->title }}
                                </a>
                            </h3>
                            @php
                                echo $review->content;
                            @endphp
                                <a href="#" class="like @if (!Auth::user()->likes()->where('likeable_id', $review->id)->where('likeable_type', 'App\Models\Review')->exists()) d-none @endif" id="unlike" data-likeable_type="App\Models\Review" data-likeable_id="{{ $review->id }}" data-user_id="{{ Auth::user()->id }}"><i class="fas fa-thumbs-up pull-left"></i></a>&nbsp;
                                <a href="#" class="like @if (Auth::user()->likes()->where('likeable_id', $review->id)->where('likeable_type', 'App\Models\Review')->exists()) d-none @endif" id="like" data-likeable_type="App\Models\Review" data-likeable_id="{{ $review->id }}" data-user_id="{{ Auth::user()->id }}"><i class="far fa-thumbs-up pull-left"></i></a>&nbsp;
                            <span class="like_num">(<span id="like_num">{{ $review->like_num }}</span>)</span>
                        </div>
                        <div class="recipe-reviews">
                            <div class="section-heading heading-dark">
                                <h2 class="item-heading">{{ trans('msg.comment') }}</h2>
                            </div>
                            <ul>
                                <input type="hidden" id="count" value="{{ $comments->count() }}">
                                <input type="hidden" id="review_id" value="{{ $review->id }}">
                                <input type="hidden" id="msg_submit" value="{{ trans('msg.submit') }}">
                                <input type="hidden" id="msg_delete" value="{{ trans('msg.delete') }}">
                                <input type="hidden" id="msg_delete_confirm" value="{{ trans('msg.delete_confirm') }}">
                                @foreach ($comments as $index => $comment)
                                    <li class="reviews-single-item" @if (Auth::user()->id == $comment->user_id) id="li{{ $index }}" @endif>
                                    <div class="media media-none--xs" @if (Auth::user()->id == $comment->user_id) id="comment{{ $index }}" @endif >
                                        @if (Auth::user()->id == $comment->user_id)
                                            <button type="button" class="btn btn-secondary x-btn" data-toggle="modal"
                                                data-target="#exampleModal{{ $index }}">
                                                <i class="fa fa-times" aria-hidden="true"></i>
                                            </button>
                                            <div class="modal fade" id="exampleModal{{ $index }}" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"
                                                                data-id="{{ $comment->id }}"
                                                                id="delete{{ $index }}">{{ trans('msg.delete') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="media-body">
                                            <h4 class="comment-title">{{ $comment->user()->first()->name }}</h4>
                                            <span class="post-date">{{ $comment->created_at }}</span>
                                            <p id="p{{ $index }}" class="break-word">{{ $comment->content }}</p>
                                            <span class="pull-right">(<span id="cmt_like_num{{ $index }}">{{ $comment->like_num }}</span>)</span>
                                            <a href="#" class="like @if (!Auth::user()->likes()->where('likeable_id', $comment->id)->exists()) d-none @endif" id="unlike_cmt{{ $index }}" data-likeable_type="App\Models\Comment" data-likeable_id="{{ $comment->id }}" data-user_id="{{ Auth::user()->id }}"><i class="fas fa-thumbs-up pull-right"></i></a>&nbsp;
                                            <a href="#" class="like @if (Auth::user()->likes()->where('likeable_id', $comment->id)->exists()) d-none @endif" id="like_cmt{{ $index }}" data-likeable_type="App\Models\Comment" data-likeable_id="{{ $comment->id }}" data-user_id="{{ Auth::user()->id }}"><i class="far fa-thumbs-up pull-right"></i></a>&nbsp;
                                        </div>
                                    </div>
                                    <form class="leave-form-box d-none" @if (Auth::user()->id == $comment->user_id) id="comment_form{{ $index }}"@endif data-id={{ $comment->id }} data-index={{ $index }}>
                                        @csrf
                                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <textarea class="textarea form-control comment-form-control" name="content"
                                                    id="content{{ $index }}" rows="{{ config('default.comment_row') }}"
                                                    cols="{{ config('default.comment_col') }}"
                                                    required>{{ $comment->content }}</textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                            <div class="col-12 form-group mb-0">
                                                <button type="submit"
                                                    class="item-btn comment-button">{{ trans('msg.submit') }}</button>
                                            </div>
                                        </div>
                                        <div class="form-response"></div>
                                    </form>
                                    </li>
                                @endforeach
                                <div id="ajax-cmt"></div>
                                <br>
                                <li class="reviews-single-item">
                                    <form class="leave-form-box" id="comment_form">
                                        @csrf
                                        <input type="hidden" name="review_id" value="{{ $review->id }}">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <div class="row">
                                            <div class="col-12 form-group">
                                                <label>{{ trans('msg.comment') }}</label>
                                                <textarea class="textarea form-control comment-form-control" name="content"
                                                    id="content" rows="{{ config('default.comment_row') }}"
                                                    cols="{{ config('default.comment_col') }}" required></textarea>
                                                <div class="help-block with-errors"></div>
                                            </div>
                                            <div class="col-12 form-group mb-0">
                                                <button type="submit" id="submit"
                                                    class="item-btn comment-button">{{ trans('msg.submit') }}</button>
                                            </div>
                                        </div>
                                        <div class="form-response"></div>
                                    </form>
                                </li>
                            </ul>
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
    <script src="{{ asset('js/comment.js') }}"></script>
    <script src="{{ asset('js/like.js') }}"></script>
@endsection
