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

        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to purchase chapters.');
        }

        if ($user->transactions()->where('chapter_id', $chapter->id)->exists()) {
            return back()->with('error', 'You have already purchased this chapter.');
        }

        if ($user->coins < $chapter->price) {
            return back()->with('error', 'Not enough coins to purchase this chapter.');
        }

        $comic = $chapter->comic;
        $uploader = $comic->uploader;

        DB::transaction(function () use ($user, $chapter, $uploader) {
            // Deduct coins from user
            $user->decrement('coins', $chapter->price);

            // Add coins to the uploader, if they exist
            if ($uploader) {
                $uploader->increment('coins', $chapter->price);
            }

            // Create transaction record
            Transaction::create([
                'user_id' => $user->id,
                'chapter_id' => $chapter->id,
                'amount' => $chapter->price,
            ]);
        });

        return back()->with('success', 'Chapter purchased successfully! Coins have been transferred to the translator.');
    }
}