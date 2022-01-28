@if (Auth::guard('admin')->check())
    <form action="{{ route('admin.threads.destroy', $thread->id) }}" method="POST" class="md-4">
        @csrf
        @method('DELETE')
        <input type="submit" class="btn btn-light" value="削除" onclick="return confirm('スレッドを削除します。本当に実行してよろしいでしょうか？')">
    </form>
@else
    <form method="POST" action="{{ route('messages.store', $thread->id) }}" class="mb-1" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="thread-first-content">内容</label>
            <textarea name="body" class="form-control" id="thread-first-content" rows="3"
                required></textarea>
            <div class="form-group">
                <label for="message-images">画像</label>
                <input type="file" class="form-control-file" id="message-images" name="images[]" multiple>
            </div>
        </div>
        <button type="submit" class="btn btn-light">書き込む</button>
    </form>
@endif

