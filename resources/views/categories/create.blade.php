@extends('layouts.navbar')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Create Category</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Name:</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded {{ $errors->has('name') ? 'border-red-500' : '' }}" required>
            @if ($errors->has('name'))
                <p class="text-red-500 text-sm mt-2">{{ $errors->first('name') }}</p>
            @endif
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Description:</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded {{ $errors->has('description') ? 'border-red-500' : '' }}" required></textarea>
            @if ($errors->has('description'))
                <p class="text-red-500 text-sm mt-2">{{ $errors->first('description') }}</p>
            @endif
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('categories.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Save</button>
        </div>
    </form>
@endsection