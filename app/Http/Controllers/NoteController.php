<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Auth::user()->notes;
        return view('notes.index', compact('notes'));
    }

    public function create()
    {
        return view('notes.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'is_private' => 'boolean'
        ]);

        Auth::user()->notes()->create($validatedData);

        return redirect()->route('notes.index')
            ->with('success', 'Not başarıyla oluşturuldu.');
    }

    public function edit(Note $note)
    {
        // Kullanıcının kendi notunu düzenleyebilmesi
        $this->authorize('update', $note);
        return view('notes.edit', compact('note'));
    }

    public function update(Request $request, Note $note)
    {
        $this->authorize('update', $note);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'is_private' => 'boolean'
        ]);

        $note->update($validatedData);

        return redirect()->route('notes.index')
            ->with('success', 'Not başarıyla güncellendi.');
    }

    public function destroy(Note $note)
    {
        $this->authorize('delete', $note);
        $note->delete();

        return redirect()->route('notes.index')
            ->with('success', 'Not başarıyla silindi.');
    }
}