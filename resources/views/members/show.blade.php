@extends('layouts.navbar')

@section('title', 'Member Details')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Member Details</h1>
    <div class="bg-white p-6 rounded shadow border border-gray-800">
        <p><strong>ID:</strong> {{ $member->id }}</p>
        <p><strong>Name:</strong> {{ $member->name }}</p>
        <p><strong>Email:</strong> {{ $member->email }}</p>
        <p><strong>Phone:</strong> {{ $member->phone }}</p>
        <p><strong>Address:</strong> {{ $member->address }}</p>
    </div>

    <h2 class="text-2xl font-bold mt-6">Borrowed Books</h2>

    {{-- OnGoing Borrow Records --}}
    <h3 class="text-xl font-semibold mt-4">OnGoing</h3>
    @if ($member->ongoingBorrows->isEmpty())
        <p class="text-gray-500">No ongoing borrows.</p>
    @else
        <table class="table-auto w-full mt-4 border-collapse border border-gray-800">
            <thead class="bg-gray-200 border-b-2 border-gray-800">
                <tr>
                    <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Book Title</th>
                    <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Borrow Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member->ongoingBorrows as $borrow)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-800 px-6 py-3">{{ $borrow->book->title }}</td>
                        <td class="border border-gray-800 px-6 py-3">{{ $borrow->borrow_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Late Borrow Records --}}
    <h3 class="text-xl font-semibold mt-6">Late</h3>
    @if ($member->lateBorrows->isEmpty())
        <p class="text-gray-500">No late borrows.</p>
    @else
        <table class="table-auto w-full mt-4 border-collapse border border-gray-800">
            <thead class="bg-gray-200 border-b-2 border-gray-800">
                <tr>
                    <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Book Title</th>
                    <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Borrow Date</th>
                    <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Return Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member->lateBorrows as $borrow)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-800 px-6 py-3">{{ $borrow->book->title }}</td>
                        <td class="border border-gray-800 px-6 py-3">{{ $borrow->borrow_date }}</td>
                        <td class="border border-gray-800 px-6 py-3">{{ $borrow->return_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- OnTime Borrow Records --}}
    <h3 class="text-xl font-semibold mt-6">OnTime</h3>
    @if ($member->onTimeBorrows->isEmpty())
        <p class="text-gray-500">No on-time borrows.</p>
    @else
        <table class="table-auto w-full mt-4 border-collapse border border-gray-800">
            <thead class="bg-gray-200 border-b-2 border-gray-800">
                <tr>
                    <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Book Title</th>
                    <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Borrow Date</th>
                    <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Return Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($member->onTimeBorrows as $borrow)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-800 px-6 py-3">{{ $borrow->book->title }}</td>
                        <td class="border border-gray-800 px-6 py-3">{{ $borrow->borrow_date }}</td>
                        <td class="border border-gray-800 px-6 py-3">{{ $borrow->return_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('members.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 mt-4 inline-block">Back to List</a>
@endsection