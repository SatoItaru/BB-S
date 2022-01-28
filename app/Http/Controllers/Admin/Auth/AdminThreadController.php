<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Models\Thread;
use App\Models\Message;
use Carbon\Carbon;
use App\Http\Requests\ThreadRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\ThreadService;
use App\Services\MessageService;
use App\Repositories\ThreadRepository;
use App\Repositories\MessageRepository;
use App\Http\Controllers\Controller;

class AdminThreadController extends Controller
{
    protected $thread_service;

    protected $thread_repository;

    public function __construct(
        ThreadService $thread_service,
        ThreadRepository $thread_repository
    ) {
        $this->middleware('auth:admin');
        $this->thread_service = $thread_service;
        $this->thread_repository = $thread_repository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $threads = $this->thread_service->getThreads(3);
        $threads->load('messages.user', 'messages.images');
        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadRequest $request)
    {
        try {
            $data = $request->only(
                ['name','content']
            );
            $this->thread_service->createNewThread($data, Auth::id());
        } catch (Exception $error) {
            return redirect()->route('threads.index')->with('error', 'スレッドの新規作成に失敗しました');
        }

        return redirect()->route('threads.index')->with('success', 'スレッドの新規作成に成功しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $thread = $this->thread_repository->findById($id);
        $thread->load('messages.user', 'messages.images');
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->thread_repository->deleteThread($id);
        } catch (Exception $error) {
            // dd($error);
            return redirect()->route('admin.threads.index')->with('error', 'スレッドの削除に失敗しました。');
        }
        return redirect()->route('admin.threads.index')->with('success', 'スレッドの削除に成功しました。');
    }
}
