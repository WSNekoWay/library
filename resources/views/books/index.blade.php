@extends('layouts.navbar')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Books</h1>

    <!-- Search and Filter Form -->
    <form action="{{ route('books.index') }}" method="GET" class="bg-white p-6 rounded shadow-md mb-6">
        <div class="mb-4">
            <h3 class="text-lg font-semibold mb-2">Search:</h3>
            <div class="flex space-x-4">
                <input type="text" name="search" placeholder="Search by title or author"
                       value="{{ request()->search }}"
                       class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                <button type="submit" name="action" value="search" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Search</button>
            </div>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold mb-2">Filter by Categories:</h3>
            <div class="flex flex-wrap gap-4">
                @foreach ($categories as $category)
                    <label class="flex items-center">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                               {{ request()->categories && in_array($category->id, request()->categories) ? 'checked' : '' }}
                               class="mr-2">
                        {{ $category->name }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex justify-between items-center">
            <button type="submit" name="action" value="filter" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Apply Filter</button>
            <a href="{{ route('books.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Clear All</a>
        </div>
    </form>

    <a href="{{ route('books.create') }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 mb-6 inline-block">Create New Book</a>

    <!-- Borrowed Books -->
    <h2 class="text-2xl font-semibold mb-4">Borrowed Books</h2>
    <table class="w-full border-collapse border border-gray-800 mb-6">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-800 px-4 py-2">Title</th>
                <th class="border border-gray-800 px-4 py-2">Author</th>
                <th class="border border-gray-800 px-4 py-2">Published Year</th>
                <th class="border border-gray-800 px-4 py-2">Status</th>
                <th class="border border-gray-800 px-4 py-2">Categories</th>
                <th class="border border-gray-800 px-4 py-2">Borrowed By</th>
                <th class="border border-gray-800 px-4 py-2">Borrowed Date</th>
                <th class="border border-gray-800 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($borrowedBooks as $book)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-800 px-4 py-2">{{ $book->title }}</td>
                    <td class="border border-gray-800 px-4 py-2">{{ $book->author }}</td>
                    <td class="border border-gray-800 px-4 py-2">{{ $book->published_year }}</td>
                    <td class="border border-gray-800 px-4 py-2">{{ $book->status }}</td>
                    <td class="border border-gray-800 px-4 py-2">
                        @if ($book->categories->isEmpty())
                            <em>No categories</em>
                        @else
                            {{ $book->categories->pluck('name')->join(', ') }}
                        @endif
                    </td>
                    <td class="border border-gray-800 px-4 py-2">
                        @if ($book->borrows->isNotEmpty())
                            {{ $book->borrows->first()->member->name }}
                        @else
                            <em>Unknown</em>
                        @endif
                    </td>
                    <td class="border border-gray-800 px-4 py-2">
                        @if ($book->borrows->isNotEmpty())
                            {{ $book->borrows->first()->borrow_date }}
                        @else
                            <em>Unknown</em>
                        @endif
                    </td>
                    <td class="border border-gray-800 px-4 py-2">
                        <a href="{{ route('books.edit', $book->id) }}" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center border border-gray-800 px-4 py-2">No borrowed books found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Available Books -->
    <h2 class="text-2xl font-semibold mb-4">Available Books</h2>
    <table class="w-full border-collapse border border-gray-800">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-800 px-4 py-2">Title</th>
                <th class="border border-gray-800 px-4 py-2">Author</th>
                <th class="border border-gray-800 px-4 py-2">Published Year</th>
                <th class="border border-gray-800 px-4 py-2">Status</th>
                <th class="border border-gray-800 px-4 py-2">Categories</th>
                <th class="border border-gray-800 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($availableBooks as $book)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-800 px-4 py-2">{{ $book->title }}</td>
                    <td class="border border-gray-800 px-4 py-2">{{ $book->author }}</td>
                    <td class="border border-gray-800 px-4 py-2">{{ $book->published_year }}</td>
                    <td class="border border-gray-800 px-4 py-2">{{ $book->status }}</td>
                    <td class="border border-gray-800 px-4 py-2">
                        @if ($book->categories->isEmpty())
                            <em>No categories</em>
                        @else
                            {{ $book->categories->pluck('name')->join(', ') }}
                        @endif
                    </td>
                    <td class="border border-gray-800 px-4 py-2">
                        <a href="{{ route('books.edit', $book->id) }}" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Edit</a>
                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center border border-gray-800 px-4 py-2">No available books found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection