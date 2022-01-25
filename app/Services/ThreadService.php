<?php

namespace App\Services;

use Exception;
use App\Models\Thread;
use App\Models\Message;
use App\Repositories\MessageRepository;
use App\Repositories\ThreadRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ThreadService
{
    protected $message_repository;

    protected $thread_repository;

    public function __construct(
        MessageRepository $message_repository,
        ThreadRepository $thread_repository
    ) {
        $this->message_repository = $message_repository;
        $this->thread_repository = $thread_repository;
    }
    /**
     * Create new thread and first new message.
     *
     * @param array $data
     * @return Tread $thread
     */
    public function createNewThread(array $data, string $user_id)
    {
        DB::beginTransaction();
        try {
            $thread_data = $this->getThreadData($data['name'], $user_id);
            $thread = Thread::create($thread_data);

            $message_data = $this->getMessageData($data['content'], $user_id, $thread->id);
            Message::create($message_data);
        } catch (Exception $error) {
            DB::rollBack();
            Log::error($error->getMessage());
            throw new Exception($error->getMessage());
        }
        DB::commit();
        return $thread;
    }
    /**
     * get thread data
     *
     * @param string $thread_name
     * @param string $user_id
     * @return array
     */
    public function getThreadData(string $thread_name, string $user_id)
    {
        return [
            'name' => $thread_name,
            'user_id' => $user_id,
            'latest_comment_time' => Carbon::now()
        ];
    }
    /**
     * get message data
     *
     * @param string $message
     * @param string $user_id
     * @param string $thread_id
     * @return array
     */
    public function getMessageData(string $message, string $user_id, string $thread_id)
    {
        return [
            'body' => $message,
            'user_id' => $user_id,
            'thread_id' => $thread_id
        ];
    }

    public function getThreads(int $per_page)
    {
        $threads = $this->thread_repository->getPaginatedThreads($per_page);
        $threads->load('user', 'messages.user');
        return $threads;
    }

    public function convertUrl(string $message)
    {
        $message = e($message);
        $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
        $replace = '<a href="$1" target="_blank">$1</a>';
        $message = preg_replace($pattern, $replace, $message);
        return $message;
    }
}
