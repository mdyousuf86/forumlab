<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Forum;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $pageTitle  = 'All Categories';
        $categories = Category::searchable(['name', 'forum:name'])->with('forum:id,name')->orderBy('id', 'desc')->paginate(getPaginate());
        $forums     = Forum::active()->latest()->get();
        return view('admin.category.index', compact('pageTitle', 'categories', 'forums'));
    }

    public function store(Request $request, $id = 0)
    {
        $request->validate([
            'forum_id'    => 'required|integer|exists:forums,id',
            'name'        => 'required|string|max:40|unique:categories,name,' . $id,
            'icon'        => 'required',
            'description' => 'required|string|max:255',
        ]);

        if ($id) {
            $category     = Category::findOrFail($id);
            $notification = 'Category updated successfully';
        } else {
            $category     = new Category();
            $notification = 'Category created successfully';
        }

        $category->forum_id    = $request->forum_id;
        $category->name        = $request->name;
        $category->icon        = $request->icon;
        $category->description = $request->description;
        $category->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function status($id)
    {
        return Category::changeStatus($id);
    }
}
