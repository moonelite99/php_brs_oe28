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
                            <th>{{ trans('msg.sent_time') }}</th>
                            <th>{{ trans('msg.title') }}</th>
                            <th>{{ trans('msg.show') }}</th>
                            <th>{{ trans('msg.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reviews as $review)
                            <tr>
                                <td>{{ $review->updated_at }}</td>
                                <td>
                                    <p class="limit-text">
                                        {{ $review->title }}
                                    </p>
                                </td>
                                <td>
                                    <a role="button" class="btn btn-primary" href="{{ route('show_book', $review->book->id) }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#exampleModal{{ $review->id }}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="exampleModal{{ $review->id }}" tabindex="-1" role="dialog"
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
                                                        action="{{ route('reviews.destroy', $review->id) }}">
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
            <div class="pull-right">{{ $reviews->links() }}</div>
        </div>
    </div>
@endsection
