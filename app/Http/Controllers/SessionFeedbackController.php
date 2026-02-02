<?php

namespace App\Http\Controllers;

use App\Models\CounselingSession;
use App\Models\SessionFeedback;
use Illuminate\Http\Request;

class SessionFeedbackController extends Controller
{
    public function store(Request $request, CounselingSession $session)
    {
        $user = auth()->user();
        
        // Validate that the session is completed
        if (!$session->canReceiveFeedback()) {
            return back()->with('error', 'Feedback can only be provided for completed sessions.');
        }
        
        // Determine feedback type based on user role and session relationship
        $feedbackType = null;
        if ($session->student_id === $user->id) {
            $feedbackType = 'student_to_counselor';
        } elseif ($session->counselor_id === $user->id) {
            $feedbackType = 'counselor_to_student';
        } else {
            // Check if user is a participant in group session
            if ($session->isGroupSession() && $session->isParticipant($user->id)) {
                $feedbackType = 'student_to_counselor';
            } else {
                abort(403, 'You are not authorized to provide feedback for this session.');
            }
        }
        
        // Check if feedback already exists
        if ($session->hasFeedbackFrom($user->id, $feedbackType)) {
            return back()->with('error', 'You have already provided feedback for this session.');
        }
        
        $validated = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'feedback_text' => 'required|string|min:10|max:1000',
            'is_anonymous' => 'nullable|boolean',
        ]);
        
        SessionFeedback::create([
            'counseling_session_id' => $session->id,
            'user_id' => $user->id,
            'feedback_type' => $feedbackType,
            'rating' => $validated['rating'] ?? null,
            'feedback_text' => $validated['feedback_text'],
            'is_anonymous' => $request->has('is_anonymous'),
        ]);
        
        return back()->with('success', 'Thank you for your feedback! It has been shared with the other party.');
    }
    
    public function update(Request $request, CounselingSession $session, SessionFeedback $feedback)
    {
        $user = auth()->user();
        
        // Ensure the feedback belongs to the authenticated user
        if ($feedback->user_id !== $user->id) {
            abort(403, 'You can only edit your own feedback.');
        }
        
        // Ensure the feedback belongs to the session
        if ($feedback->counseling_session_id !== $session->id) {
            abort(404, 'Feedback not found for this session.');
        }
        
        $validated = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
            'feedback_text' => 'required|string|min:10|max:1000',
            'is_anonymous' => 'nullable|boolean',
        ]);
        
        $feedback->update([
            'rating' => $validated['rating'] ?? null,
            'feedback_text' => $validated['feedback_text'],
            'is_anonymous' => $request->has('is_anonymous'),
        ]);
        
        return back()->with('success', 'Your feedback has been updated successfully.');
    }
    
    public function destroy(CounselingSession $session, SessionFeedback $feedback)
    {
        $user = auth()->user();
        
        // Ensure the feedback belongs to the authenticated user
        if ($feedback->user_id !== $user->id) {
            abort(403, 'You can only delete your own feedback.');
        }
        
        // Ensure the feedback belongs to the session
        if ($feedback->counseling_session_id !== $session->id) {
            abort(404, 'Feedback not found for this session.');
        }
        
        $feedback->delete();
        
        return back()->with('success', 'Your feedback has been deleted.');
    }
}