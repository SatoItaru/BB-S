<?php

namespace App\Repositories;

use App\Models\Thread;

class ThreadRepository
{
    /**
     * @var Thread
     */
    protected $thread;
    /**
     * ThreadRepository constructor.
     *
     * @param Thread $thread
     */
    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }
    /**
     * Create new Thread.
     *
     * @param array $data
     * @return Thread $thread
     */
    public function create(array $data)
    {
        return $this->thread->create($data);
    }
}
