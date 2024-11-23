@extends('layouts.navbar')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Create Borrow Record</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('borrows.store') }}" method="POST" class="bg-white p-6 rounded shadow-md">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Member:</label>
            <select name="member_id" class="w-full px-4 py-2 border rounded" required>
                <option value="">Select Member</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                        {{ $member->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Book:</label>
            <select name="book_id" class="w-full px-4 py-2 border rounded" required>
                <option value="">Select Book</option>
                @foreach ($books as $book)
                    <option value="{{ $book->id }}" {{ old('book_id') == $book->id ? 'selected' : '' }}>
                        {{ $book->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Borrow Date:</label>
            <input type="datetime-local" name="borrow_date" value="{{ old('borrow_date', now()->format('Y-m-d\TH:i')) }}"
                   class="w-full px-4 py-2 border rounded" required>
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('borrows.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">Cancel</a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Create Borrow</button>
        </div>
    </form>
@endsection