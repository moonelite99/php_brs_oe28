<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>

<body>
    <h2>Cirilla</h2>
    <h4>{{ trans('msg.review') }}</h4>
    <ul>
        @if (!$reviews->isEmpty())
            @foreach ($reviews as $review)
                <a href="{{ route('reviews.show', $review->id) }}">
                    <li>{{ $review->title }}</li>
                </a>
            @endforeach
        @else
            {{ trans('msg.no_new_review') }}
        @endif
    </ul>
    <h4>{{ trans('msg.book') }}</h4>
    <ul>
        @if (!$books->isEmpty())
            @foreach ($books as $book)
                <a href="{{ route('books.show', $book->id) }}">
                    <li>{{ $book->title }}</li>
                </a>
            @endforeach
        @else
            {{ trans('msg.no_new_book') }}
        @endif
    </ul>
</body>

</html>
