<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller {
    public function index() {
        $pageTitle     = 'All Subcategories';
        $subcategories = Subcategory::searchable(['name', 'category:name'])->with('category:id,name')->orderBy('id', 'desc')->paginate(getPaginate());
        $categories    = Category::active()->orderBy('name')->get();
        return view('admin.subcategory.index', compact('pageTitle', 'subcategories', 'categories'));
    }

    public function store(Request $request, $id = 0) {
        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'name'        => 'required|string|max:40',
        ]);

        if ($id) {
            $subcategory  = Subcategory::findOrFail($id);
            $notification = 'Subcategory updated successfully';
        } else {
            $subcategory  = new Subcategory();
            $notification = 'Subcategory created successfully';
        }

        $subcategory->category_id = $request->category_id;
        $subcategory->name        = $request->name;
        $subcategory->save();

        $notify[] = ['success', $notification];
        return back()->withNotify($notify);
    }

    public function status($id) {
        return Subcategory::changeStatus($id);
    }
}
