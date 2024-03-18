<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;

class ForumController extends Controller
{
    public function index()
    {
        $pageTitle = 'All Forum';
        $forums    = Forum::searchable(['name'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view('admin.forum.index', compact('pageTitle', 'forums'));
    }
    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'name' => 'required|string|max:40|unique:forums,name,' . $id,
            'icon' => 'required|string',
        ]);

        if ($id) {
            $forum        = Forum::findOrFail($id);
            $notification = 'Forum updated successfully';
        } else {
            $forum        = new Forum();
            $notification = 'Forum created successfully';
        }

        $forum->name = $request->name;
        $forum->icon = $request->icon;
        $forum->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Forum::changeStatus($id);
    }
}
