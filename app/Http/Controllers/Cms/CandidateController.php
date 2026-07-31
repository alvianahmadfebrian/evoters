<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CandidateController extends Controller
{
    /**
     * Store a newly created candidate in storage.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'candidate_number' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'candidate_number', 'description']);
        $data['event_id'] = $event->id;

        // Process photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            
            // Ensure folder exists
            if (!file_exists(public_path('uploads/candidates'))) {
                mkdir(public_path('uploads/candidates'), 0755, true);
            }

            $file->move(public_path('uploads/candidates'), $filename);
            $data['photo'] = 'uploads/candidates/' . $filename;
        }

        Candidate::create($data);

        return redirect()->route('cms.events.show', $event->id)->with('success', 'Kandidat berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the candidate.
     */
    public function edit(Candidate $candidate)
    {
        $candidate->load('event');
        return view('cms.candidates.edit', compact('candidate'));
    }

    /**
     * Update the candidate.
     */
    public function update(Request $request, Candidate $candidate)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'candidate_number' => 'required|integer',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['name', 'candidate_number', 'description']);

        // Process photo upload
        if ($request->hasFile('photo')) {
            // Delete old file if exists
            if ($candidate->photo && file_exists(public_path($candidate->photo))) {
                @unlink(public_path($candidate->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/candidates'))) {
                mkdir(public_path('uploads/candidates'), 0755, true);
            }

            $file->move(public_path('uploads/candidates'), $filename);
            $data['photo'] = 'uploads/candidates/' . $filename;
        }

        $candidate->update($data);

        return redirect()->route('cms.events.show', $candidate->event_id)->with('success', 'Kandidat berhasil diperbarui.');
    }

    /**
     * Delete the candidate.
     */
    public function destroy(Candidate $candidate)
    {
        $eventId = $candidate->event_id;

        // Delete photo
        if ($candidate->photo && file_exists(public_path($candidate->photo))) {
            @unlink(public_path($candidate->photo));
        }

        $candidate->delete();

        return redirect()->route('cms.events.show', $eventId)->with('success', 'Kandidat berhasil dihapus.');
    }
}
