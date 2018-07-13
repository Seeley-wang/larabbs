<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Http\Request;

class categoriesController extends Controller
{
    /**
     * @param Category $category
     * @param Request $request
     * @param Topic $topic
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Category $category, Request $request, Topic $topic, User $user)
    {
        $topics = $topic->withOrder($request->order)
            ->where('category_id', $category->id)
            ->paginate(20);

        // 活跃用户列表
        $active_users = $user->getActivesUsers();

        return view('topics.index', compact('topics', 'category', 'active_users'));
    }
}
