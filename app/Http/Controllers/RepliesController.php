<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * @param ReplyRequest $request
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReplyRequest $request, Reply $reply)
    {
        $reply->content = $request['content'];
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $reply->save();

        return redirect()->to($reply->topic->link())->with('success', '创建成功！');
    }

    /**
     * @param Reply $reply
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Reply $reply)
    {
        try {
            $this->authorize('destroy', $reply);
        } catch (AuthorizationException $e) {
            return redirect('/');
        }
        try {
            $reply->delete();
        } catch (\Exception $e) {
        }

        return redirect()->route('replies.index')->with('message', '删除成功');
    }
}