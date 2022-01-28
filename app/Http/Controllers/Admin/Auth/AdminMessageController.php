<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Thread;
use App\Repositories\MessageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminMessageController extends Controller
{
    protected $message_repository;

    public function __construct(
        MessageRepository $message_repository
    ) {
        $this->middleware('auth:admin');
        $this->message_repository = $message_repository;
    }

    public function destroy(Thread $thread, $id)
    {
        try {
            $this->message_repository->deleteMessage($id);
        } catch (Exception $error) {
            return redirect()->route('admin.threads.show', $thread->id)->with('error', 'メッセージの削除に失敗しました。');
        }
        return redirect()->route('admin.threads.show', $thread->id)->with('success', 'メッセージの削除に成功しました。');
    }
}
