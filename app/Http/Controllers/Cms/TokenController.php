<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TokenController extends Controller
{
    /**
     * Generate bulk tokens for an event.
     */
    public function generate(Request $request, Event $event)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:1000',
        ]);

        $quantity = $request->integer('quantity');
        $generated = 0;
        $maxAttempts = $quantity * 3; // To prevent infinite loop if conflicts arise
        $attempts = 0;

        while ($generated < $quantity && $attempts < $maxAttempts) {
            $attempts++;
            // Generate a code e.g. VT-R3A79X
            $code = 'VT-' . strtoupper(Str::random(6));

            // Check uniqueness
            if (!Token::where('code', $code)->exists()) {
                Token::create([
                    'event_id' => $event->id,
                    'code' => $code,
                    'is_used' => false,
                ]);
                $generated++;
            }
        }

        return redirect()->route('cms.events.show', $event->id)
            ->with('success', "$generated token berhasil dibuat.");
    }

    /**
     * Clear all unused tokens for an event.
     */
    public function clear(Event $event)
    {
        $deleted = Token::where('event_id', $event->id)
            ->where('is_used', false)
            ->delete();

        return redirect()->route('cms.events.show', $event->id)
            ->with('success', "$deleted token belum terpakai berhasil dihapus.");
    }

    /**
     * Export tokens as TXT file download.
     */
    public function export(Event $event)
    {
        $tokens = Token::where('event_id', $event->id)->get();
        
        $content = "TOKEN EXPORT FOR EVENT: {$event->title}\n";
        $content .= "Generated At: " . now()->toDateTimeString() . "\n";
        $content .= "Format: Code | Status | Voted Email (if public) | Voted At\n";
        $content .= str_repeat("=", 60) . "\n\n";

        foreach ($tokens as $token) {
            $status = $token->is_used ? "USED" : "UNUSED";
            $votedAt = $token->voted_at ? $token->voted_at->toDateTimeString() : "-";
            $email = $token->voter_email ?? "-";
            $content .= "{$token->code} | {$status} | Email: {$email} | {$votedAt}\n";
        }

        $filename = 'tokens-' . $event->slug . '-' . date('Ymd-His') . '.txt';

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', "attachment; filename=\"{$filename}\"");
    }
}
