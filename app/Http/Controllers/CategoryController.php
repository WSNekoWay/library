<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories without execution time tracking
        $categories = Category::all();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Start the timer
        $startTime = microtime(true);

        // Validate and create the category
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        // Stop the timer
        $executionTime = microtime(true) - $startTime;

        // Set a success message with execution time
        $successMessage = 'Category created successfully.';
        $successMessage .= ' (Execution time: ' . number_format($executionTime, 4) . ' seconds)';

        return redirect()->route('categories.index')
            ->with('success', $successMessage);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        // Start the timer
        $startTime = microtime(true);

        // Validate and update the category
        $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        // Stop the timer
        $executionTime = microtime(true) - $startTime;

        // Set a success message with execution time
        $successMessage = 'Category updated successfully.';
        $successMessage .= ' (Execution time: ' . number_format($executionTime, 4) . ' seconds)';

        return redirect()->route('categories.index')
            ->with('success', $successMessage);
    }

    public function destroy(Category $category)
    {
        // Start the timer
        $startTime = microtime(true);

        // Delete the category
        $category->delete();

        // Stop the timer
        $executionTime = microtime(true) - $startTime;

        // Set a success message with execution time
        $successMessage = 'Category deleted successfully.';
        $successMessage .= ' (Execution time: ' . number_format($executionTime, 4) . ' seconds)';

        return redirect()->route('categories.index')
            ->with('success', $successMessage);
    }
}