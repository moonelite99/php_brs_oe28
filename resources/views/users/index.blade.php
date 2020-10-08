@extends('layouts.admin')

@section('content')
    @if (session('fail_status'))
        <div class="toast noti text-danger" data-delay="{{ config('default.noti_time') }}">
            <div class="toast-header">
                <strong class="mr-auto">{{ trans('msg.notification') }}</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
                {{ session('fail_status') }}
            </div>
        </div>
    @endif
    @if (session('status'))
        <div class="toast noti text-success" data-delay="{{ config('default.noti_time') }}">
            <div class="toast-header">
                <strong class="mr-auto">{{ trans('msg.notification') }}</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast">&times;</button>
            </div>
            <div class="toast-body">
                {{ session('status') }}
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12 pad-table">
            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>{{ trans('msg.username') }}</th>
                            <th>{{ trans('msg.email') }}</th>
                            <th>{{ trans('msg.edit') }}</th>
                            <th>{{ trans('msg.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->email }}</td>
                                <td><a name="" class="btn btn-info" role="button"
                                        href="{{ route('users.edit', $user->id) }}"><i class="far fa-edit"></i></a>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#exampleModal{{ $user->id }}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="exampleModal{{ $user->id }}" tabindex="-1" role="dialog"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">{{ $user->username }}
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
                                                    <form method="post" action="{{ route('users.destroy', $user->id) }}">
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
            <div class="pull-left">
                <a name="" class="btn btn-success" role="button" href="{{ route('users.create') }}">
                    <i class="fas fa-plus"></i> {{ trans('msg.add_user') }}
                </a>
            </div>
            <div class="pull-right">{{ $users->links() }}</div>
        </div>
    </div>
@endsection
