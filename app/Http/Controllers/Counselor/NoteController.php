<?php

namespace App\Http\Controllers\Counselor;

use App\Http\Controllers\Controller;
use App\Models\{SessionNote, CounselingSession, User};
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        
        // Get all notes for this counselor with relationships
        $notes = SessionNote::where('counselor_id', $user->id)
            ->with(['session.student', 'counselor'])
            ->latest()
            ->get();
        
        // Get clients for filter dropdown
        $clients = User::whereIn('role', ['user', 'admin'])
            ->whereHas('counselingSessions', function($query) use ($user) {
                $query->where('counselor_id', $user->id);
            })
            ->orderBy('name')
            ->get();
        
        // Statistics
        $stats = [
            'total_notes' => $notes->count(),
            'private_notes' => $notes->where('is_private', true)->count(),
            'public_notes' => $notes->where('is_private', false)->count(),
            'recent_notes' => $notes->where('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        return view('counselor.notes.index', compact('notes', 'clients', 'stats'));
    }
    
    public function create(Request $request)
    {
        $user = auth()->user();
        
        // Get sessions for this counselor
        $sessions = CounselingSession::where('counselor_id', $user->id)
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Pre-select session if provided
        $selectedSession = null;
        if ($request->filled('session_id')) {
            $selectedSession = $sessions->where('id', $request->session_id)->first();
        }
        
        return view('counselor.notes.create', compact('sessions', 'selectedSession'));
    }
    
    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'session_id' => 'required|exists:counseling_sessions,id',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:progress,observation,reminder,general',
            'is_private' => 'boolean',
        ]);
        
        // Verify the session belongs to this counselor
        $session = CounselingSession::where('id', $validated['session_id'])
            ->where('counselor_id', $user->id)
            ->firstOrFail();
        
        SessionNote::create([
            'session_id' => $validated['session_id'],
            'counselor_id' => $user->id,
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'is_private' => $request->has('is_private'),
        ]);
        
        return redirect()
            ->route('counselor.notes.index')
            ->with('success', 'Session note created successfully!');
    }
    
    public function show(SessionNote $note)
    {
        $user = auth()->user();
        
        // Ensure the note belongs to this counselor
        if ($note->counselor_id !== $user->id) {
            abort(403, 'You are not authorized to view this note.');
        }
        
        $note->load(['session.student', 'counselor']);
        
        return view('counselor.notes.show', compact('note'));
    }
    
    public function edit(SessionNote $note)
    {
        $user = auth()->user();
        
        // Ensure the note belongs to this counselor
        if ($note->counselor_id !== $user->id) {
            abort(403, 'You are not authorized to edit this note.');
        }
        
        $sessions = CounselingSession::where('counselor_id', $user->id)
            ->with('student')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $note->load('session.student');
        
        return view('counselor.notes.edit', compact('note', 'sessions'));
    }
    
    public function update(Request $request, SessionNote $note)
    {
        $user = auth()->user();
        
        // Ensure the note belongs to this counselor
        if ($note->counselor_id !== $user->id) {
            abort(403, 'You are not authorized to update this note.');
        }
        
        $validated = $request->validate([
            'session_id' => 'required|exists:counseling_sessions,id',
            'title' => 'nullable|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:progress,observation,reminder,general',
            'is_private' => 'boolean',
        ]);
        
        // Verify the session belongs to this counselor
        $session = CounselingSession::where('id', $validated['session_id'])
            ->where('counselor_id', $user->id)
            ->firstOrFail();
        
        $note->update([
            'session_id' => $validated['session_id'],
            'title' => $validated['title'],
            'content' => $validated['content'],
            'type' => $validated['type'],
            'is_private' => $request->has('is_private'),
        ]);
        
        return redirect()
            ->route('counselor.notes.index')
            ->with('success', 'Session note updated successfully!');
    }
    
    public function destroy(SessionNote $note)
    {
        $user = auth()->user();
        
        // Ensure the note belongs to this counselor
        if ($note->counselor_id !== $user->id) {
            abort(403, 'You are not authorized to delete this note.');
        }
        
        $note->delete();
        
        return redirect()
            ->route('counselor.notes.index')
            ->with('success', 'Session note deleted successfully!');
    }
}