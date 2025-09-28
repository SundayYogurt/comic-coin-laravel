<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Comic;
use App\Models\Page;

class ChapterController extends Controller
{
    // แสดงรายการ Chapter
    public function index() {
        $chapters = Chapter::all();
        return view('chapters.index', compact('chapters'));
    }

    // ฟอร์มสร้าง Chapter + อัพโหลด Pages
    public function create() {
        $comics = Comic::all(); // admin เลือก comic
        return view('chapters.create', compact('comics'));
    }

    // สร้าง Chapter และอัพโหลด Pages
   public function store(Request $request)
{
    $validated = $request->validate([
        'comic_id' => 'required|exists:comics,id',
        'chapter_number' => 'required|integer|min:1',
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|integer|min:0',
        'images.*' => 'required|image|max:4096',
    ]);

    // สร้าง Chapter
    $chapter = Chapter::create($validated);

    // บันทึก Pages
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('chapter_pages', 'public');
            $chapter->pages()->create([
                'page_number' => $index + 1,
                'image_path' => $path,
            ]);
        }
    }

    return redirect()->route('comics.show', $validated['comic_id'])
                     ->with('success', 'Chapter and pages added successfully!');
}

    public function edit(Chapter $chapter) {
        $comics = Comic::all();
        return view('chapters.edit', compact('chapter', 'comics'));
    }

    public function update(Request $request, Chapter $chapter) {
        $validated = $request->validate([
            'comic_id' => 'required|exists:comics,id',
            'chapter_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
        ]);

        $chapter->update($validated);

        return redirect()->route('comics.show', $chapter->comic_id)
            ->with('success', 'Chapter updated successfully!');
    }

    public function destroy(Chapter $chapter) {
        $chapter->delete();
        return redirect()->route('comics.show', $chapter->comic_id)
            ->with('success', 'Chapter deleted successfully!');
    }

    // แสดง Chapter พร้อม Pages
    public function show(Chapter $chapter)
    {
        $user = auth()->user();

        // โหลด Pages
        $chapter->load('pages');

        // ถ้า Chapter ฟรี
        if ($chapter->price == 0) return view('chapters.show', compact('chapter'));

        // Admin สามารถเข้าถึงได้
        if ($user && $user->is_admin) return view('chapters.show', compact('chapter'));

        // ตรวจสอบว่าซื้อแล้ว
        if ($user && $user->transactions()->where('chapter_id', $chapter->id)->exists()) {
            return view('chapters.show', compact('chapter'));
        }

        // ไม่ซื้อ → redirect
        return redirect()->route('comics.show', $chapter->comic_id)
            ->with('error', 'You must purchase this chapter to view it.');
    }
}
