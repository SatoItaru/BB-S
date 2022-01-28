@if (Auth::guard('admin')->check())
    <a href="{{ route('admin.threads.index') }}" class="btn btn-light">掲示板に戻る</a>
@else
    <a href="{{ route('threads.index') }}" class="btn btn-light">掲示板に戻る</a>
@endif
