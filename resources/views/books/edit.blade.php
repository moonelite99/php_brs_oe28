@extends('layouts.admin')

@section('content')
    <div class="col-lg-8 offset-lg-2">
        <div class="card">
            <div class="card-header">
                <strong>{{ trans('msg.edit_book') }}</strong>
            </div>
            <div class="card-body card-block">
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
                <form action="{{ route('books.update', $book->id) }}" id="form" method="POST" enctype="multipart/form-data"
                    class="form-horizontal">
                    @csrf
                    @method('PUT')
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ trans('msg.title') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="title" class="form-control @error ('title') is-invalid @enderror"
                                value="{{ $book->title }}" autofocus required>
                            @error ('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ trans('msg.author') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="text" name="author" class="form-control @error ('author') is-invalid @enderror"
                                value="{{ $book->author }}" required>
                            @error ('author')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ trans('msg.publish_date') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="date" name="publish_date"
                                class="form-control @error ('publish_date') is-invalid @enderror"
                                value="{{ $book->publish_date }}" required>
                            @error ('publish_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="text-input" class=" form-control-label">{{ trans('msg.pages_number') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <input type="number" name="pages_number"
                                class="form-control @error ('pages_number') is-invalid @enderror"
                                value="{{ $book->pages_number }}" required>
                            @error ('pages_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="textarea-input" class=" form-control-label">{{ trans('msg.description') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <textarea name="description" class="form-control @error ('description') is-invalid @enderror"
                                required>{{ $book->description }}</textarea>
                            @error ('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="multiple-select" class=" form-control-label">{{ trans('msg.category') }}</label>
                        </div>
                        <div class="col col-md-9">
                            <select name="categories[]" id="multiple-select" multiple=""
                                class="form-control @error ('categories') is-invalid @enderror" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if (in_array($category->id, $selectedCategories)) selected @endif>{{ trans('msg.' . $category->name) }}</option>
                                @endforeach
                            </select>
                            @error ('categories')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col col-md-3">
                            <label for="file-input" class=" form-control-label">{{ trans('msg.image') }}</label>
                        </div>
                        <div class="col-12 col-md-9">
                            <img src="{{ asset($book->img_path) }}">
                            <input type="file" id="file-input" name="image"
                                class="form-control-file @error ('image') is-invalid @enderror">
                            @error ('image')
                                <span class="warning">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <button type="submit" form="form" class="btn btn-primary btn-sm pull-right">
                    {{ trans('msg.submit') }}
                </button>
            </div>
        </div>
    </div>
@endsection
