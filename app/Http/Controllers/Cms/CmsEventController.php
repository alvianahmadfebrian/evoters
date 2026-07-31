<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CmsEventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::withCount(['candidates', 'tokens'])
            ->withSum('votes', 'quantity')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('cms.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        return view('cms.events.create');
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'voting_type' => 'required|in:public_email,token_only',
            'show_results' => 'required|in:always,after_voting,after_closed,secret',
            'price' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,active,paused,closed',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('banner_image');
        $data['price'] = $request->input('price') ?? 0;
        
        // Generate unique slug
        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Event::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $data['slug'] = $slug;

        // Process banner upload
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $filename = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            
            // Ensure folder exists
            if (!file_exists(public_path('uploads/banners'))) {
                mkdir(public_path('uploads/banners'), 0755, true);
            }
            
            $file->move(public_path('uploads/banners'), $filename);
            $data['banner_image'] = 'uploads/banners/' . $filename;
        }

        Event::create($data);

        return redirect()->route('cms.events.index')->with('success', 'Event berhasil dibuat.');
    }

    /**
     * Display the specified event (Monitor & Details).
     */
    public function show(Event $event)
    {
        // Load candidates and sum votes quantity
        $event->load(['candidates' => function($q) {
            $q->withSum('votes', 'quantity');
        }]);

        $totalVotes = (int)$event->votes()->sum('quantity');
        $totalTokens = $event->tokens()->count();
        $usedTokens = $event->tokens()->where('is_used', true)->count();
        
        // Paginate tokens
        $tokens = $event->tokens()->orderBy('created_at', 'desc')->paginate(20, ['*'], 'token_page');
        
        // Recent vote activity
        $recentVotes = $event->votes()
            ->with('candidate')
            ->orderBy('voted_at', 'desc')
            ->paginate(15, ['*'], 'vote_page');

        return view('cms.events.show', compact('event', 'totalVotes', 'totalTokens', 'usedTokens', 'tokens', 'recentVotes'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        return view('cms.events.edit', compact('event'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'voting_type' => 'required|in:public_email,token_only',
            'show_results' => 'required|in:always,after_voting,after_closed,secret',
            'price' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,active,paused,closed',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except('banner_image');
        $data['price'] = $request->input('price') ?? 0;

        // Regenerate slug if title changes
        if ($request->title !== $event->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Event::where('slug', $slug)->where('id', '!=', $event->id)->exists()) {
                $slug = $originalSlug . '-' . $count;
                $count++;
            }
            $data['slug'] = $slug;
        }

        // Process banner upload
        if ($request->hasFile('banner_image')) {
            // Delete old file if exists
            if ($event->banner_image && file_exists(public_path($event->banner_image))) {
                @unlink(public_path($event->banner_image));
            }

            $file = $request->file('banner_image');
            $filename = time() . '_' . Str::random(5) . '.' . $file->getClientOriginalExtension();
            
            if (!file_exists(public_path('uploads/banners'))) {
                mkdir(public_path('uploads/banners'), 0755, true);
            }

            $file->move(public_path('uploads/banners'), $filename);
            $data['banner_image'] = 'uploads/banners/' . $filename;
        }

        $event->update($data);

        return redirect()->route('cms.events.show', $event->id)->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Delete banner image
        if ($event->banner_image && file_exists(public_path($event->banner_image))) {
            @unlink(public_path($event->banner_image));
        }

        // Delete candidates photos
        foreach ($event->candidates as $candidate) {
            if ($candidate->photo && file_exists(public_path($candidate->photo))) {
                @unlink(public_path($candidate->photo));
            }
        }

        $event->delete();

        return redirect()->route('cms.events.index')->with('success', 'Event berhasil dihapus.');
    }
}
