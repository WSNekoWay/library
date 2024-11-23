@extends('layouts.navbar')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Borrow Records</h1>
    <a href="{{ route('borrows.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Create New Borrow Record</a>

    @foreach (['OnGoing' => $ongoingBorrows, 'Late' => $lateBorrows, 'OnTime' => $onTimeBorrows] as $status => $borrows)
        <h2 class="text-2xl font-semibold mb-4">{{ $status }} Borrow Records</h2>
        <table class="table-auto w-full border-collapse border border-gray-800 mb-6">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-800 px-4 py-2">#</th>
                    <th class="border border-gray-800 px-4 py-2">ID</th>
                    <th class="border border-gray-800 px-4 py-2">Member</th>
                    <th class="border border-gray-800 px-4 py-2">Book</th>
                    <th class="border border-gray-800 px-4 py-2">Borrow Date</th>
                    <th class="border border-gray-800 px-4 py-2">Return Date</th>
                    <th class="border border-gray-800 px-4 py-2">Status</th>
                    <th class="border border-gray-800 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($borrows as $borrow)
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-800 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-800 px-4 py-2">{{ $borrow->id }}</td>
                        <td class="border border-gray-800 px-4 py-2">{{ $borrow->member->name }}</td>
                        <td class="border border-gray-800 px-4 py-2">{{ $borrow->book->title }}</td>
                        <td class="border border-gray-800 px-4 py-2">{{ $borrow->borrow_date }}</td>
                        <td class="border border-gray-800 px-4 py-2">{{ $borrow->return_date ?? 'Not returned yet' }}</td>
                        <td class="border border-gray-800 px-4 py-2">{{ $borrow->status }}</td>
                        <td class="border border-gray-800 px-4 py-2">
                            <a href="{{ route('borrows.edit', $borrow->id) }}" class="bg-green-500 text-white px-2 py-1 rounded hover:bg-green-600">Edit</a>
                            <form action="{{ route('borrows.destroy', $borrow->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center border border-gray-800 px-4 py-2">No {{ strtolower($status) }} borrow records found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach
@endsection