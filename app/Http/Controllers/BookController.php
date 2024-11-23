<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $action = $request->input('action');

        $borrowedBooksQuery = Book::with(['categories', 'borrows.member'])
            ->where('status', 'Borrowed');

        $availableBooksQuery = Book::with('categories')
            ->where('status', 'Available');

        if ($action === 'filter') {
            if ($request->has('categories') && is_array($request->categories)) {
                $selectedCategories = $request->categories;

                $borrowedBooksQuery->whereHas('categories', function ($q) use ($selectedCategories) {
                    $q->whereIn('categories.id', $selectedCategories)
                        ->havingRaw('COUNT(DISTINCT categories.id) = ?', [count($selectedCategories)]);
                }, '=', count($selectedCategories));

                $availableBooksQuery->whereHas('categories', function ($q) use ($selectedCategories) {
                    $q->whereIn('categories.id', $selectedCategories)
                        ->havingRaw('COUNT(DISTINCT categories.id) = ?', [count($selectedCategories)]);
                }, '=', count($selectedCategories));
            }
        } elseif ($request->filled('search')) {
            $search = $request->search;
            $borrowedBooksQuery->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                    ->orWhere('author', 'LIKE', "%$search%");
            });

            $availableBooksQuery->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                    ->orWhere('author', 'LIKE', "%$search%");
            });
        }

        $borrowedBooks = $borrowedBooksQuery->get();
        $availableBooks = $availableBooksQuery->get();

        return view('books.index', compact('borrowedBooks', 'availableBooks', 'categories'));
    }

    public function create()
    {
        $startTime = microtime(true);

        $categories = Category::all();

        $executionTime = microtime(true) - $startTime;
        return view('books.create', compact('categories'))
            ->with('success', 'Book creation page loaded successfully. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }

    public function store(Request $request)
    {
        $startTime = microtime(true);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'status' => 'required|in:Borrowed,Available',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $book = Book::create($request->only(['title', 'author', 'published_year', 'status']));
        $book->categories()->syncWithPivotValues(
            $request->categories ?? [],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $executionTime = microtime(true) - $startTime;

        return redirect()->route('books.index')
            ->with('success', 'Book created successfully with categories. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }

    public function show(Book $book)
    {
        $book->load('categories');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $startTime = microtime(true);

        $categories = Category::all();

        $executionTime = microtime(true) - $startTime;

        return view('books.edit', compact('book', 'categories'))
            ->with('success', 'Book edit page loaded successfully. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }

    public function update(Request $request, Book $book)
    {
        $startTime = microtime(true);

        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_year' => 'required|integer',
            'status' => 'required|in:Borrowed,Available',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
        ]);

        $book->update($request->only(['title', 'author', 'published_year', 'status']));
        $book->categories()->syncWithPivotValues(
            $request->categories ?? [],
            ['updated_at' => now()]
        );

        $executionTime = microtime(true) - $startTime;

        return redirect()->route('books.index')
            ->with('success', 'Book updated successfully with categories. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }

    public function destroy(Book $book)
    {
        $startTime = microtime(true);

        $book->categories()->detach();
        $book->delete();

        $executionTime = microtime(true) - $startTime;

        return redirect()->route('books.index')
            ->with('success', 'Book deleted successfully. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }
}