<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryManagementController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('skills')->latest()->get();
        return view('admin.category', compact('categories'));
    }

    public function store(Request $request)
    {
      $request->validate([
        'name' => 'required|unique:categories,name'
      ]);

      Category::create($request->only('name', 'description'));

      return back()->with('success', 'Category created successfully');
    }

    public function update(Request $request, $id)
    {
      $category = Category::findOrFail($id);

      $request->validate([
        'name' => 'required|unique:categories,name,$id',
        'description' => 'nullable'
      ]);

      $category->update($request->only('name', 'description'));

      return back()->with('success', 'Category updated successfully');
    }

    public function destroy(Request $request, $id)
    {
      Category::findOrFail($id)->delete();

      return back()->with('success', 'Category deleted successfully');
    }
}
