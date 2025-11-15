<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillManagementController extends Controller
{
    public function index()
    {
        $skills = Skill::with('category')->withCount('artisans')->latest()->get();
        $categories = Category::all();

        return view('admin.skills', compact('skills', 'categories'));
    }


    public function store(StoreSkillRequest $request)
    {
        $skill = Skill::create($request->validated());

        return redirect()->back()->with('success', 'Skill added successfully!');
    }

    public function update(Request $request, $id)
    {
       $skill = Skill::findOrFail($id);
       $request->validate([
        'name' => 'required|unique:skills,name,$id',
        'category_id' => 'nullable|exists:categories,id'
       ]);

       $skill->update($request->only('name', 'category_id'));
       return back()->with('success', 'Skill updated successfully');
    }

    public function destroy($id)
    {
       Skill::findOrFail($id)->delete();
       return back()->with('success', 'Skill deleted successfully');
    }
}
