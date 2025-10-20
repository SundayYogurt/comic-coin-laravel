<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'addCoins']);
    }

    // For User Top-up
    public function showTopupForm()
    {
        $topupPackages = [
            ['coins' => 100, 'price' => 35, 'bonus' => 0],
            ['coins' => 300, 'price' => 100, 'bonus' => 10],
            ['coins' => 500, 'price' => 175, 'bonus' => 25],
            ['coins' => 1000, 'price' => 350, 'bonus' => 70],
            ['coins' => 2000, 'price' => 700, 'bonus' => 150],
            ['coins' => 5000, 'price' => 1750, 'bonus' => 400],
        ];

        return view('wallet.topup', compact('topupPackages'));
    }

    public function processTopup(Request $request)
    {
        $request->validate([
            'coins' => 'required|integer|min:1',
        ]);

        $user = Auth::user();
        $user->coins += $request->coins;
        $user->save();

        return redirect()->route('wallet.topup')->with('success', 'Successfully topped up ' . $request->coins . ' coins!');
    }


    // For Admin
    public function index()
    {
        $users = User::all();
        return view('wallet.index', compact('users'));
    }

    public function addCoins(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'coins'   => 'required|integer|min:1',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return redirect()->route('wallet.index')->with('error', 'User not found!');
        }

        $user->coins += $request->coins;
        $user->save();

        return redirect()->route('wallet.index')->with('success', $request->coins . ' coins added to ' . $user->name . '!');
    }
}
