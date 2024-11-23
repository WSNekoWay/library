@extends('layouts.navbar')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Edit Book</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.update', $book->id) }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Title:</label>
            <input type="text" name="title" value="{{ $book->title }}" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Author:</label>
            <input type="text" name="author" value="{{ $book->author }}" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Published Year:</label>
            <input type="number" name="published_year" value="{{ $book->published_year }}" class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Status:</label>
            <select name="status" class="w-full px-4 py-2 border rounded" required>
                <option value="Available" {{ $book->status == 'Available' ? 'selected' : '' }}>Available</option>
                <option value="Borrowed" {{ $book->status == 'Borrowed' ? 'selected' : '' }}>Borrowed</option>
            </select>
        </div>

        <div class="mb-4">
            <h3 class="text-lg font-semibold">Edit Categories:</h3>
            @foreach ($categories as $category)
                <label class="inline-flex items-center mt-2">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="form-checkbox"
                           {{ $book->categories->contains($category->id) ? 'checked' : '' }}>
                    <span class="ml-2">{{ $category->name }}</span>
                </label>
            @endforeach
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('books.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Book</button>
        </div>
    </form>
@endsection