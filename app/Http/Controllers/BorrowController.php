<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Member;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ongoingBorrows = Borrow::with(['member', 'book'])->where('status', 'OnGoing')->get();
        $lateBorrows = Borrow::with(['member', 'book'])->where('status', 'Late')->get();
        $onTimeBorrows = Borrow::with(['member', 'book'])->where('status', 'OnTime')->get();

        return view('borrows.index', compact('ongoingBorrows', 'lateBorrows', 'onTimeBorrows'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $startTime = microtime(true);

        $members = Member::all();
        $books = Book::where('status', 'Available')->get();

        $executionTime = microtime(true) - $startTime;

        return view('borrows.create', compact('members', 'books'))
            ->with('success', 'Borrow creation page loaded successfully. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $startTime = microtime(true);

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
        ]);

        $existingBorrow = Borrow::where('book_id', $request->book_id)
                                ->where('status', 'OnGoing')
                                ->first();

        if ($existingBorrow) {
            return redirect()->back()->withErrors(['book_id' => 'This book is already borrowed by another member.']);
        }

        Borrow::create($request->all());
        $book = Book::find($request->book_id);
        $book->update(['status' => 'Borrowed']);

        $executionTime = microtime(true) - $startTime;

        return redirect()->route('borrows.index')
            ->with('success', 'Borrow record created successfully. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }

    /**
     * Show the form for editing a resource.
     */
    public function edit(Borrow $borrow)
    {
        $startTime = microtime(true);

        $members = Member::all();
        $books = Book::where('status', 'Available')->orWhere('id', $borrow->book_id)->get();

        $executionTime = microtime(true) - $startTime;

        return view('borrows.edit', compact('borrow', 'members', 'books'))
            ->with('success', 'Borrow edit page loaded successfully. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrow $borrow)
    {
        $startTime = microtime(true);

        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'return_date' => 'nullable|date',
            'status' => 'required|in:OnGoing,OnTime,Late',
        ]);

        if ($request->book_id != $borrow->book_id) {
            $oldBook = $borrow->book;
            $oldBook->update(['status' => 'Available']);

            $newBook = Book::findOrFail($request->book_id);
            $newBook->update(['status' => 'Borrowed']);
        }

        if ($request->status === 'OnGoing') {
            $existingBorrow = Borrow::where('book_id', $request->book_id)
                ->where('status', 'OnGoing')
                ->where('id', '!=', $borrow->id)
                ->first();

            if ($existingBorrow) {
                return redirect()->back()->withErrors(['book_id' => 'This book is already marked as OnGoing for another borrow record.']);
            }

            $request->merge(['return_date' => null]);
        }

        $borrow->update($request->all());

        $executionTime = microtime(true) - $startTime;

        return redirect()->route('borrows.index')
            ->with('success', 'Borrow record updated successfully. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrow $borrow)
    {
        $startTime = microtime(true);

        if ($borrow->status === 'OnGoing') {
            $borrow->book->update(['status' => 'Available']);
        }

        $borrow->delete();

        $executionTime = microtime(true) - $startTime;

        return redirect()->route('borrows.index')
            ->with('success', 'Borrow record deleted successfully. (Execution time: ' . number_format($executionTime, 4) . ' seconds)');
    }
}