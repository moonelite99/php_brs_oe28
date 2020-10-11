@extends('layouts.admin')

@section('content')
    <div class="row">
        <h2 class="title-1 pad-title">
            {{ $status == config('default.req_unsolved') ? trans('msg.unsolved_request') : trans('msg.solved_request') }}
        </h2>
        <div class="col-lg-12 pad-table">
            <div class="table-responsive table--no-card m-b-30">
                <table class="table table-borderless table-striped table-earning">
                    <thead>
                        <tr>
                            <th>{{ trans('msg.sender') }}</th>
                            <th>{{ trans('msg.content') }}</th>
                            @if ($status == config('default.req_unsolved'))
                                <th>{{ trans('msg.show') }}</th>
                            @else
                                <th>{{ trans('msg.manager') }}</th>
                            @endif
                            <th>{{ trans('msg.delete') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->user->name }}</td>
                                <td>
                                    <p class="limit-text">
                                        {{ $contact->content }}
                                    </p>
                                </td>
                                @if ($status == config('default.req_unsolved'))
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#showModal{{ $contact->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <div class="modal fade" id="showModal{{ $contact->id }}" tabindex="-1" role="dialog"
                                            aria-labelledby="showModal" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="showModal">{{ $contact->user->name }}
                                                        </h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <textarea class="center" cols="{{ config('default.contact_col_admin') }}" rows="{{ config('default.contact_row') }}"
                                                            readonly>{{ $contact->content }}</textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form method="post"
                                                            action="{{ route('contacts.update', $contact->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="{{ config('default.req_solved') }}">
                                                            <input type="hidden" name="manager_id" value="{{ Auth::user()->id }}">
                                                            <div>
                                                                <button type="submit" class="btn btn-success"
                                                                    onclick="">{{ trans('msg.mark_as_solved') }}</button>
                                                            </div>
                                                        </form>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">{{ trans('msg.close') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @else
                                    <td>{{ $contact->manager->name }}</td>
                                @endif

                                <td>
                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                        data-target="#exampleModal{{ $contact->id }}">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                    <div class="modal fade" id="exampleModal{{ $contact->id }}" tabindex="-1" role="dialog"
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
                                                        action="{{ route('contacts.destroy', $contact->id) }}">
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
                <a name="" class="btn btn-secondary" role="button"
                    @if ($status == config('default.req_solved'))
                        href="{{ route('requests', config('default.req_unsolved')) }}">
                        {{ trans('msg.unsolved_request') }}
                    @else
                        href="{{ route('requests', config('default.req_solved')) }}">
                        {{ trans('msg.solved_request') }}
                    @endif
                </a>
            </div>
            <div class="pull-right">{{ $contacts->links() }}</div>
        </div>
    </div>
@endsection
