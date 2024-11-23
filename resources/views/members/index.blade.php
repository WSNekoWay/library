@extends('layouts.navbar')

@section('title', 'Members')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Members</h1>
    <a href="{{ route('members.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mb-4 inline-block">Add New Member</a>

    @if (session('success'))
        <p class="bg-green-100 text-green-700 px-4 py-2 rounded mt-4">{{ session('success') }}</p>
    @endif

    <table class="table-auto w-full mt-6 border-collapse border border-gray-800">
        <thead class="bg-gray-200 border-b-2 border-gray-800">
            <tr>
                <th class="border border-gray-800 px-6 py-3 text-left font-semibold">ID</th>
                <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Name</th>
                <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Email</th>
                <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Phone</th>
                <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Address</th>
                <th class="border border-gray-800 px-6 py-3 text-left font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
                <tr class="hover:bg-gray-100">
                    <td class="border border-gray-800 px-6 py-3">{{ $member->id }}</td>
                    <td class="border border-gray-800 px-6 py-3">{{ $member->name }}</td>
                    <td class="border border-gray-800 px-6 py-3">{{ $member->email }}</td>
                    <td class="border border-gray-800 px-6 py-3">{{ $member->phone }}</td>
                    <td class="border border-gray-800 px-6 py-3">{{ $member->address }}</td>
                    <td class="border border-gray-800 px-6 py-3">
                        <a href="{{ route('members.show', $member) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 inline-block">View</a>
                        <a href="{{ route('members.edit', $member) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 inline-block ml-2">Edit</a>
                        <form action="{{ route('members.destroy', $member) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 inline-block ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    
@endsection