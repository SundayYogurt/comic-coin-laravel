<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    // แก้ไขหน้าที่มีอยู่
    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'page_number' => 'required|integer|min:1',
            'image' => 'nullable|image|max:4096',
        ]);

        $chapter = $page->chapter()->first();
        if (!$chapter) {
            return redirect()->back()->with('error', 'Chapter not found for this page.');
        }

        $originalPageNumber = $page->page_number;
        $newPageNumber = $validated['page_number'];

        // Handle image replacement
        if ($request->hasFile('image')) {
            if ($page->image_path) {
                Storage::disk('public')->delete($page->image_path);
            }
            $path = $request->file('image')->store('chapter_pages', 'public');
            $page->image_path = $path;
        }

        if ($originalPageNumber != $newPageNumber) {
            DB::transaction(function () use ($chapter, $page, $originalPageNumber, $newPageNumber) {
                // Find the page to swap with
                $otherPage = $chapter->pages()->where('page_number', $newPageNumber)->first();

                if ($otherPage) {
                    // Swap page numbers
                    $otherPage->update(['page_number' => $originalPageNumber]);
                    $page->update(['page_number' => $newPageNumber]);
                } else {
                    $page->update(['page_number' => $newPageNumber]);
                }
            });
        } else {
            $page->save();
        }

        return redirect()->route('chapters.show', $chapter)->with('success', 'Page updated successfully!');
    }

    public function destroy(Page $page)
    {
        $chapter = $page->chapter()->first();
        if (!$chapter) {
            return redirect()->back()->with('error', 'Chapter not found for this page.');
        }
        
        $deletedPageNumber = $page->page_number;

        // Delete the image file
        if ($page->image_path) {
            Storage::disk('public')->delete($page->image_path);
        }

        DB::transaction(function () use ($chapter, $page, $deletedPageNumber) {
            // Delete the page
            $page->delete();

            // Decrement the page numbers of subsequent pages
            $chapter->pages()
                ->where('page_number', '>', $deletedPageNumber)
                ->decrement('page_number');
        });

        return redirect()->route('chapters.show', $chapter)->with('success', 'Page deleted successfully!');
    }
}
