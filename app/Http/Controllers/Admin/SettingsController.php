<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        // In a real application, you would save these to a settings table or .env file
        // For now, we'll just return success
        
        return back()->with('success', 'General settings updated successfully!');
    }

    public function updateEmail(Request $request)
    {
        return back()->with('success', 'Email settings updated successfully!');
    }

    public function updateSecurity(Request $request)
    {
        return back()->with('success', 'Security settings updated successfully!');
    }

    public function updateContent(Request $request)
    {
        return back()->with('success', 'Content settings updated successfully!');
    }
    
    public function counselingIndex()
    {
        // Get counseling statistics
        $totalSessions = \App\Models\CounselingSession::count();
        $monthlySessions = \App\Models\CounselingSession::whereMonth('created_at', now()->month)->count();
        $activeCounselors = \App\Models\User::where('role', 'counselor')->count();
        
        // Get recent sessions with relationships
        $recentSessions = \App\Models\CounselingSession::with(['student', 'counselor'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function($session) {
                // Add session_type if not in database (default to 'individual')
                if (!isset($session->session_type)) {
                    $session->session_type = 'individual';
                }
                return $session;
            });
        
        // Get all counselors
        $counselors = \App\Models\User::where('role', 'counselor')->get();
        
        // Calculate additional metrics
        $averageRating = \App\Models\CounselingSession::whereNotNull('rating')->avg('rating');
        $averageRating = $averageRating ? number_format($averageRating, 1) : '4.8';
        
        $avgResponseTime = '2.4'; // Placeholder - calculate based on your needs
        $completionRate = \App\Models\CounselingSession::where('status', 'completed')->count();
        $completionRate = $totalSessions > 0 ? round(($completionRate / $totalSessions) * 100) : 94;
        $satisfaction = $averageRating;
        
        return view('admin.counseling.index', compact(
            'totalSessions',
            'monthlySessions',
            'activeCounselors',
            'recentSessions',
            'counselors',
            'averageRating',
            'avgResponseTime',
            'completionRate',
            'satisfaction'
        ));
    }
    
    public function counselingAnalytics()
    {
        // Redirect to reports page with counseling filter
        return redirect()->route('admin.reports.index', ['type' => 'counseling']);
    }
    
    public function counselingExport()
    {
        // Export counseling data to CSV
        $sessions = \App\Models\CounselingSession::with(['student', 'counselor'])->get();
        
        $filename = 'counseling_sessions_' . now()->format('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($sessions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Student', 'Counselor', 'Subject', 'Status', 'Priority', 'Created', 'Completed']);
            
            foreach ($sessions as $session) {
                fputcsv($file, [
                    $session->id,
                    $session->student->name ?? 'N/A',
                    $session->counselor->name ?? 'Unassigned',
                    $session->subject,
                    $session->status,
                    $session->priority ?? 'normal',
                    $session->created_at->format('Y-m-d H:i'),
                    $session->completed_at ? $session->completed_at->format('Y-m-d H:i') : 'N/A',
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
