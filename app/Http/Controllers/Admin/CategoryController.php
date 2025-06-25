<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get root categories (categories without parent)
        $rootCategories = Category::whereNull('parent_id')
            ->with('children')
            ->orderBy('name')
            ->get();
            
        // Get all categories for the dropdown in create/edit forms
        $allCategories = Category::orderBy('name')->get();
        
        // Count statistics
        $stats = [
            'total_categories' => Category::count(),
            'root_categories' => Category::whereNull('parent_id')->count(),
            'child_categories' => Category::whereNotNull('parent_id')->count(),
            'used_categories' => Category::has('courses')->count(),
        ];
            
        return view('admin.categories.index', compact('rootCategories', 'allCategories', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:categories',
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'parent_id' => 'nullable|exists:categories,id'
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->route('admin.categories.create')
                ->withErrors($validator)
                ->withInput();
        }
        
        Category::create([
            'name' => $request->name,
            'icon' => $request->icon,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
        ]);
        
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load(['courses', 'parent', 'children']);
        
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Get all categories except the current one and its descendants
        // This prevents creating circular references
        $selfAndDescendantIds = $category->descendants()->pluck('id')->push($category->id);
        $categories = Category::whereNotIn('id', $selfAndDescendantIds)->orderBy('name')->get();
        
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id)
            ],
            'icon' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    // Prevent assigning a category as its own parent or a descendant as its parent
                    if ($value == $category->id) {
                        $fail('A category cannot be its own parent.');
                    } elseif ($value && $category->descendants()->pluck('id')->contains($value)) {
                        $fail('A category cannot have one of its descendants as its parent.');
                    }
                }
            ]
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->route('admin.categories.edit', $category->id)
                ->withErrors($validator)
                ->withInput();
        }
        
        $category->update([
            'name' => $request->name,
            'icon' => $request->icon,
            'description' => $request->description,
            'parent_id' => $request->parent_id,
        ]);
        
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Check if category has courses
        if ($category->courses()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete this category because it has courses associated with it.');
        }
        
        // Update children categories to have the parent of the category being deleted
        $category->children()->update(['parent_id' => $category->parent_id]);
        
        // Delete the category
        $category->delete();
        
        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
