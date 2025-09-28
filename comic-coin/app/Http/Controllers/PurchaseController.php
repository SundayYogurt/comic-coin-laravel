<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function store(Request $request, Chapter $chapter)
    {
        $user = Auth::user();

        // 1. Check if user is logged in (already handled by middleware, but good to be explicit)
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to purchase chapters.');
        }

        // 2. Check if user has already purchased the chapter
        if ($user->transactions()->where('chapter_id', $chapter->id)->exists()) {
            return back()->with('error', 'You have already purchased this chapter.');
        }

        // 3. Check if user has enough coins
        if ($user->coins < $chapter->price) {
            return back()->with('error', 'Not enough coins to purchase this chapter.');
        }

        // 4. Perform the transaction
        DB::transaction(function () use ($user, $chapter) {
            // Deduct coins from user
            $user->coins -= $chapter->price;
            $user->save();

            // Create transaction record
            Transaction::create([
                'user_id' => $user->id,
                'chapter_id' => $chapter->id,
                'amount' => $chapter->price,
            ]);
        });

        return back()->with('success', 'Chapter purchased successfully!');
    }
}
