@extends('layouts.admin')

@section('content')
    @if (session('fail_status'))
        <div class="alert alert-danger pad-noti">
            {{ session('fail_status') }}
        </div>
    @endif
    @if (session('status'))
        <div class="alert alert-success pad-noti">
            {{ session('status') }}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 pad-table">
            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>{{ trans('msg.title') }}</th>
                            <th>{{ trans('msg.author') }}</th>
                            <th>{{ trans('msg.edit') }}</th>
                            <th>{{ trans('msg.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($books as $index => $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->author }}</td>
                                <td><a name="" class="btn btn-info" role="button"
                                        href="{{ route('books.edit', $book->id) }}"><i class="far fa-edit"></i></a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#exampleModal{{ $book->id }}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="exampleModal{{ $book->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ $book->title }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    {{ trans('msg.delete_confirm') }}
                                                </div>
                                                <div class="modal-footer">
                                                    <form method="post" action="{{ route('books.destroy', $book->id) }}">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="pull-left">
                <a name="" class="btn btn-success" role="button" href="{{ route('books.create') }}">
                    <i class="fas fa-plus"></i> {{ trans('msg.add_book') }}
                </a>
            </div>
            <div class="pull-right">{{ $books->links() }}</div>
        </div>
    </div>
@endsection
