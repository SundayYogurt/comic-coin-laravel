<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class WalletController extends Controller
{
    // หน้า admin topup user
    public function index()
    {
        $users = User::all(); // ดึง user ทั้งหมด
        return view('wallet.index', compact('users'));
    }

    // เพิ่ม coins ให้ user
    public function addCoins(Request $request)
    {
        // ตรวจสอบข้อมูลที่เข้ามา
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
