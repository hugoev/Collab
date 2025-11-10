<?php

namespace App\Http\Controllers;

use App\Events\DocumentUpdated;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Auth::user()->documents()->latest()->get();
        return view('dashboard', compact('documents'));
    }

    public function show(Document $document)
    {
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }
        return view('editor', compact('document'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
        ]);

        $document = Auth::user()->documents()->create([
            'title' => $request->title,
            'content' => $request->content ?? '',
        ]);

        return redirect()->route('documents.show', $document);
    }

    public function update(Request $request, Document $document)
    {
        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'content' => 'nullable|string',
        ]);

        $document->update([
            'content' => $request->content ?? '',
        ]);

        // Broadcast the update to all connected clients
        broadcast(new DocumentUpdated($document))->toOthers();

        return response()->json(['success' => true]);
    }
}
