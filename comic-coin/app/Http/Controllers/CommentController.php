<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Chapter $chapter)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:2|max:1000',
            'hp' => 'nullable|string|size:0',
        ], [
            'hp.size' => 'Spam detected.',
        ]);

        // Prevent rapid repeat submissions (cooldown 10 seconds per user per chapter)
        $recent = Comment::where('chapter_id', $chapter->id)
            ->where('user_id', $request->user()->id)
            ->where('created_at', '>=', now()->subSeconds(10))
            ->exists();
        if ($recent) {
            return redirect()->route('chapters.show', $chapter)->with('error', 'Please wait a few seconds before commenting again.');
        }

        // Prevent duplicate content within last 2 minutes on same chapter
        $dup = Comment::where('chapter_id', $chapter->id)
            ->where('user_id', $request->user()->id)
            ->where('content', $validated['content'])
            ->where('created_at', '>=', now()->subMinutes(2))
            ->exists();
        if ($dup) {
            return redirect()->route('chapters.show', $chapter)->with('error', 'Duplicate comment detected.');
        }

        Comment::create([
            'chapter_id' => $chapter->id,
            'user_id' => $request->user()->id,
            'content' => $validated['content'],
        ]);

        return redirect()->route('chapters.show', $chapter)->with('success', 'Comment posted.');
    }

    public function destroy(Comment $comment)
    {
        $user = auth()->user();
        if (!$user) {
            abort(403);
        }
        if (!($user->is_admin || $comment->user_id === $user->id)) {
            abort(403);
        }

        $chapter = $comment->chapter;
        $comment->delete();

        return redirect()->route('chapters.show', $chapter)->with('success', 'Comment deleted.');
    }
}
