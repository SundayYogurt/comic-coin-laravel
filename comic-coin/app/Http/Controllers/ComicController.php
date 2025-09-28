<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ComicController extends Controller
{
    public function index()
    {
        $comics = Comic::latest()->get();
        return view('comics.index', compact('comics'));
    }

    public function create()
    {
        return view('comics.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Comic::create($validated);

        return redirect()->route('comics.index')->with('success', 'Comic added successfully!');
    }

    public function edit(Comic $comic)
    {
        return view('comics.edit', compact('comic'));
    }

    public function update(Request $request, Comic $comic)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'author' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($comic->cover_image) {
                Storage::disk('public')->delete($comic->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $comic->update($validated);

        return redirect()->route('comics.index')->with('success', 'Comic updated successfully!');
    }

    public function destroy(Comic $comic)
    {
        if ($comic->cover_image) {
            Storage::disk('public')->delete($comic->cover_image);
        }
        $comic->delete();

        return redirect()->route('comics.index')->with('success', 'Comic deleted successfully!');
    }

    public function show(Comic $comic)
    {
        $comic->load('chapters');

        $purchasedChapterIds = collect();
        if (Auth::check()) {
            $purchasedChapterIds = Auth::user()->transactions()
                ->whereIn('chapter_id', $comic->chapters->pluck('id'))
                ->pluck('chapter_id');
        }

        return view('comics.show', compact('comic', 'purchasedChapterIds'));
    }

    public function toggleFavorite(Comic $comic)
    {
        $user = Auth::user();

        if ($user->favoriteComics->contains($comic->id)) {
            $user->favoriteComics()->detach($comic->id);
            $message = 'Comic removed from favorites!';
        } else {
            $user->favoriteComics()->attach($comic->id);
            $message = 'Comic added to favorites!';
        }

        return back()->with('success', $message);
    }
}
