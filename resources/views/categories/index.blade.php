@extends('layouts.navbar')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Categories</h1>
    <a href="{{ route('categories.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Add New Category</a>

    @if (session('success'))
        <p class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">{{ session('success') }}</p>
    @endif

    <table class="table-auto w-full border-collapse border border-gray-800">
        <thead class="bg-gray-200">
            <tr>
                <th class="border border-gray-800 px-4 py-2">ID</th>
                <th class="border border-gray-800 px-4 py-2">Name</th>
                <th class="border border-gray-800 px-4 py-2">Description</th>
                <th class="border border-gray-800 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $category)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-800 px-4 py-2">{{ $category->id }}</td>
                    <td class="border border-gray-800 px-4 py-2">{{ $category->name }}</td>
                    <td class="border border-gray-800 px-4 py-2">{{ $category->description }}</td>
                    <td class="border border-gray-800 px-4 py-2">
                        <a href="{{ route('categories.edit', $category) }}" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection