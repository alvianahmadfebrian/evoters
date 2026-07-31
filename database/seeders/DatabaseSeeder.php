<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Candidate;
use App\Models\Token;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin Accounts
        User::updateOrCreate(
            ['email' => 'admin@evoters.test'],
            [
                'name' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'mastervian@evoters.test'],
            [
                'name' => 'mastervian',
                'password' => Hash::make('Proats27&'),
            ]
        );

        // 2. Seed Event 1: Marching Band (Token Based)
        $event1 = Event::create([
            'title' => 'Pemilihan Marching Band Terfavorit - Festival Harmoni 2026',
            'slug' => 'marching-band-favorit-2026',
            'description' => "Pilih Marching Band terfavorit pilihan Anda dalam ajang Festival Harmoni Nusantara 2026. Kompetisi ini diikuti oleh berbagai sekolah menengah atas terbaik dengan penampilan koreografi dan aransemen musik spektakuler.\n\nVoting ini menggunakan sistem Token Privat. Silakan dapatkan kode token dari panitia festival untuk mulai memilih.",
            'banner_image' => 'images/marching_band_banner.png',
            'status' => 'active',
            'voting_type' => 'token_only',
            'show_results' => 'always',
            'price' => 2000,
            'start_time' => now()->subDays(1),
            'end_time' => now()->addDays(5),
        ]);

        $c1 = Candidate::create([
            'event_id' => $event1->id,
            'name' => 'Marching Band Gita Swara (SMA 1)',
            'candidate_number' => 1,
            'photo' => 'images/candidate_mb_one.png',
            'description' => "Marching Band dari SMA Negeri 1 Evoters. Membawa aransemen bertema 'Nusantara Modern' dengan formasi dinamis, visual megah, dan ketukan perkusi yang solid.",
        ]);

        $c2 = Candidate::create([
            'event_id' => $event1->id,
            'name' => 'Marching Band Nada Kencana (SMA 2)',
            'candidate_number' => 2,
            'photo' => 'images/candidate_mb_two.png',
            'description' => "Marching Band dari SMA Negeri 2 Evoters. Terkenal dengan tiupan kuningan (brass section) yang sangat harmonis, penuh tenaga, dan aksi color guard yang atraktif serta artistik.",
        ]);

        // Generate 15 tokens, mark 8 as used, and create votes
        for ($i = 1; $i <= 15; $i++) {
            $code = 'VT-MB' . sprintf("%02d", $i);
            $isUsed = $i <= 8;
            
            $token = Token::create([
                'event_id' => $event1->id,
                'code' => $code,
                'is_used' => $isUsed,
                'voted_at' => $isUsed ? now()->subMinutes(rand(10, 200)) : null,
            ]);

            if ($isUsed) {
                // Determine candidate (Gita Swara gets 5, Nada Kencana gets 3)
                $candidateId = ($i % 3 === 0) ? $c2->id : $c1->id;
                
                Vote::create([
                    'event_id' => $event1->id,
                    'candidate_id' => $candidateId,
                    'voter_identifier' => sha1($code),
                    'payment_status' => 'completed',
                    'amount' => 2000,
                    'quantity' => 1,
                    'payment_ref' => 'EV-SEED-MB-' . sprintf('%02d', $i) . '-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(5)),
                    'voted_at' => $token->voted_at,
                ]);
            }
        }


        // 3. Seed Event 2: Bogor Marching Band (Email OTP Based)
        $event2 = Event::create([
            'title' => 'Bogor Marching Band Championship 2026 - Tugu Kujang',
            'slug' => 'bogor-marching-band-2026',
            'description' => "Kompetisi Marching Band bergengsi se-Jawa Barat yang diselenggarakan di area Tugu Kujang, Bogor. Menyuguhkan penampilan kolosal yang memukau dari berbagai unit marching band terbaik.\n\nVoting ini terbuka untuk umum secara transparan dengan verifikasi OTP Email untuk mencegah manipulasi suara.",
            'banner_image' => 'images/bogor_mb_banner.png',
            'status' => 'active',
            'voting_type' => 'public_email',
            'show_results' => 'always',
            'price' => 5000,
            'start_time' => now()->subDays(2),
            'end_time' => now()->addDays(10),
        ]);

        $tc1 = Candidate::create([
            'event_id' => $event2->id,
            'name' => 'Marching Band Kujang Siliwangi (Bogor)',
            'candidate_number' => 1,
            'photo' => 'images/candidate_mb_one.png',
            'description' => "Unit marching band unggulan Bogor dengan aransemen kolosal khas Jawa Barat dan koreografi dinamis.",
        ]);

        $tc2 = Candidate::create([
            'event_id' => $event2->id,
            'name' => 'Marching Band Swara Pajajaran (Bogor)',
            'candidate_number' => 2,
            'photo' => 'images/candidate_mb_two.png',
            'description' => "Membawa tema kepahlawanan Pajajaran klasik dikombinasikan dengan sentuhan brass modern.",
        ]);

        $tc3 = Candidate::create([
            'event_id' => $event2->id,
            'name' => 'Marching Band Gita Pakuan (Bogor)',
            'candidate_number' => 3,
            'photo' => null,
            'description' => "Menampilkan konfigurasi formasi rumit dan harmonisasi perkusi yang intens.",
        ]);

        $tc4 = Candidate::create([
            'event_id' => $event2->id,
            'name' => 'Marching Band Nada Pajajaran (Bogor)',
            'candidate_number' => 4,
            'photo' => null,
            'description' => "Menyuguhkan visual color guard yang dramatis dan aransemen tiup (brass section) yang merdu.",
        ]);

        // Simulate 45 email votes (Kujang: 22, Swara: 12, Gita: 5, Nada: 6)
        $simulatedEmailsCount = 45;
        for ($i = 1; $i <= $simulatedEmailsCount; $i++) {
            $email = "voter{$i}@evoters.test";
            
            if ($i <= 22) {
                $cand = $tc1->id;
            } elseif ($i <= 34) {
                $cand = $tc2->id;
            } elseif ($i <= 39) {
                $cand = $tc3->id;
            } else {
                $cand = $tc4->id;
            }

            Vote::create([
                'event_id' => $event2->id,
                'candidate_id' => $cand,
                'voter_identifier' => sha1($email),
                'payment_status' => 'completed',
                'amount' => 5000,
                'payment_ref' => 'EV-SEED-BOGOR-' . sprintf('%03d', $i) . '-' . \Illuminate\Support\Str::upper(\Illuminate\Support\Str::random(5)),
                'voted_at' => now()->subHours(rand(1, 40)),
            ]);
        }
    }
}
