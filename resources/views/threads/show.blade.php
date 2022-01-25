@extends('layouts.app')

@section('content')
@inject('message_service', 'App\Services\MessageService' )
<div class="container mt-3">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @include('layouts.flash-message')
            <h3>{{ $thread->name }}</h3>
        </div>
        <div class="col-md-10 mb-3">
            <a href="{{ route('threads.index') }}" class="btn btn-light">掲示板に戻る</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10 mb-5">
            @foreach ($thread->messages as $message)
                <div class="card mb-2">
                    <div class="card-body">
                        <p>{{ $loop->iteration }} {{ $message->user->name }} {{ $message->created_at }}</p>
                        <p class="mb-0">{!! $message_service->convertUrl($message->body) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <h5 class="card-header">レスを投稿する</h5>
                <div class="card-body">
                    <form method="POST" action="{{ 'messages.store', $thread->id }}" class="mb-4">
                        @csrf
                        <div class="form-group">
                            <label for="thread-first-content">内容</label>
                            <textarea name="body" id="thread-first-content" rows="3" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-light">書き込む</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
