<?php
namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create');
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Start the timer
        $startTime = microtime(true);

        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:members,email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        // Store the member
        Member::create($request->all());

        // Stop the timer
        $executionTime = microtime(true) - $startTime;

        // Append execution time to success message
        $successMessage = 'Member created successfully.';
        $successMessage .= ' (Execution time: ' . number_format($executionTime, 4) . ' seconds)';

        return redirect()->route('members.index')->with('success', $successMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        // Start the timer
        $startTime = microtime(true);
    
        // Load the member with their borrows
        $member->load(['ongoingBorrows.book', 'onTimeBorrows.book', 'lateBorrows.book']);
    
        // Stop the timer
        $executionTime = microtime(true) - $startTime;
    
        // Set a success message with execution time
        $successMessage = 'Successfully fetched member details.';
        $successMessage .= ' (Execution time: ' . number_format($executionTime, 4) . ' seconds)';
    
        // Pass member and success message to the view
        return view('members.show', compact('member'))
            ->with('success', $successMessage);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        // Start the timer
        $startTime = microtime(true);

        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:members,email,' . $member->id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
        ]);

        // Update the member
        $member->update($request->all());

        // Stop the timer
        $executionTime = microtime(true) - $startTime;

        // Append execution time to success message
        $successMessage = 'Member updated successfully.';
        $successMessage .= ' (Execution time: ' . number_format($executionTime, 4) . ' seconds)';

        return redirect()->route('members.index')->with('success', $successMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        // Start the timer
        $startTime = microtime(true);

        // Delete the member
        $member->delete();

        // Stop the timer
        $executionTime = microtime(true) - $startTime;

        // Append execution time to success message
        $successMessage = 'Member deleted successfully.';
        $successMessage .= ' (Execution time: ' . number_format($executionTime, 4) . ' seconds)';

        return redirect()->route('members.index')->with('success', $successMessage);
    }
}