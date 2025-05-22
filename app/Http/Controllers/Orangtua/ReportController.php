<?php

namespace App\Http\Controllers\Orangtua;

use App\Http\Controllers\Controller;
use App\Models\ReportDaily;
use App\Models\Child;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    /**
     * Display a listing of the reports for the authenticated user.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $query = ReportDaily::where('user_id', $userId);
        
        // Apply date filters if provided
        if ($request->has('start_date') && $request->start_date) {
            $query->where('tanggal', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && $request->end_date) {
            $query->where('tanggal', '<=', $request->end_date);
        }
        
        $reports = $query->latest()->get();
        
        return view('dashboard.orangtua.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new report.
     */
    public function create()
    {
        $userId = Auth::id();
        $children = Child::where('user_id', $userId)->get();
        
        return view('dashboard.orangtua.reports.create', compact('children'));
    }

    /**
     * Store a newly created report in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'child_id' => 'required|exists:table_child,id',
            'tanggal' => 'required|date',
            'judul_report' => 'required|string|max:255',
            'isi_report' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        // Ensure the user can only create reports for their own children
        $userId = Auth::id();
        $childBelongsToUser = Child::where('user_id', $userId)
                                  ->where('id', $request->child_id)
                                  ->exists();
        
        if (!$childBelongsToUser) {
            return redirect()->route('dashboard.orangtua.reports.index')
            ->with('error', 'You can only create reports for your own children.');
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('report_images', 'public');
            $validated['image'] = $imagePath;
        }
        
        // Add user_id to the validated data
        $validated['user_id'] = $userId;
        
        ReportDaily::create($validated);
        
        return redirect()->route('dashboard.orangtua.reports.index')
        ->with('success', 'Report created successfully.');
    }

    /**
     * Display the specified report.
     */
    public function show($id)
    {
        $userId = Auth::id();
        $report = ReportDaily::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        
        return view('dashboard.orangtua.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified report.
     */
    public function edit($id)
    {
        $userId = Auth::id();
        $report = ReportDaily::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        
        $children = Child::where('user_id', $userId)->get();
        
        return view('dashboard.orangtua.reports.edit', compact('report', 'children'));
    }

    /**
     * Update the specified report in storage.
     */
    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $report = ReportDaily::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        
        $validated = $request->validate([
            'child_id' => 'required|exists:table_child,id',
            'tanggal' => 'required|date',
            'judul_report' => 'required|string|max:255',
            'isi_report' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        $childBelongsToUser = Auth::user()->children()->where('id', $request->child_id)->exists();
        
        if (!$childBelongsToUser) {
            return redirect()->route('dashboard.orangtua.reports.index')
                ->with('error', 'You can only create reports for your own children.');
        }
        
        if ($request->hasFile('image')) {
            if ($report->image) {
                Storage::disk('public')->delete($report->image);
            }
            
            $imagePath = $request->file('image')->store('report_images', 'public');
            $validated['image'] = $imagePath;
        }
        
        $report->update($validated);
        
        return redirect()->route('dashboard.orangtua.reports.index')->with('success', 'Report updated successfully.');
    }

    /**
     * Remove the specified report from storage.
     */
    public function destroy($id)
    {
        $userId = Auth::id();
        $report = ReportDaily::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        
        // Delete image if exists
        if ($report->image) {
            Storage::disk('public')->delete($report->image);
        }
        
        $report->delete();
        
        return redirect()->route('dashboard.orangtua.reports.index')
            ->with('success', 'Report deleted successfully.');
    }
}