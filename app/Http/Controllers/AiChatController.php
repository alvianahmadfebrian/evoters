<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array',
        ]);

        $userMessage = $request->input('message');
        $chatHistory = $request->input('history', []);

        $apiKey = env('GROQ_API_KEY');
        $model = env('GROQ_MODEL', 'llama-3.1-8b-instant');

        if (!$apiKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Layanan asisten Vera sedang dinonaktifkan (API Key belum dikonfigurasi).'
            ], 500);
        }

        $systemPrompt = "Nama Anda adalah Vera. Anda adalah Customer Service AI (Virtual Assistant) resmi untuk platform E-Voters.id.\n\n" .
            "PERATURAN UTAMA:\n" .
            "1. Anda HANYA boleh menjawab pertanyaan yang berkaitan dengan platform E-Voters.id, fitur-fiturnya, visi/misi, tata cara penggunaan platform, dan informasi mengenai pendirinya (Aries Mulyono).\n" .
            "2. Jika pengguna menanyakan hal lain di luar topik tersebut (seperti pemrograman, matematika, resep makanan, bantuan menulis kode, tugas umum, dll), Anda harus menolak dengan sopan. Contoh: 'Maaf, sebagai asisten Vera, saya hanya dapat membantu menjawab pertanyaan seputar platform E-Voters.id. Ada yang bisa saya bantu terkait voting online Anda?'\n" .
            "3. Gunakan bahasa Indonesia yang ramah, sopan, komunikatif, profesional, dan membantu. JANGAN menggunakan terlalu banyak emoji. Maksimal hanya gunakan 1 emoji dalam satu respon atau bahkan gausah pakai emoji sama sekali.\n" .
            "4. Jawablah secara singkat, padat, dan jelas agar mudah dibaca di dalam widget chat box yang kecil.\n" .
            "5. JANGAN PERNAH menyebutkan kata 'Token', 'OTP', 'Payment Gateway', atau 'Doku'.\n\n" .
            "KNOWLEDGE BASE E-VOTERS.ID:\n" .
            "- **Apa itu E-Voters.id?**: Platform pemungutan suara (e-voting) online modern, terbuka, transparan, aman, praktis, dan ramah lingkungan (paperless) untuk digitalisasi demokrasi.\n" .
            "- **Sasaran Platform**: Digunakan oleh berbagai instansi, sekolah (seperti pemilihan OSIS), kampus (pemilihan BEM), komunitas, organisasi, hingga korporasi/perusahaan di Indonesia.\n" .
            "- **Pendaftaran Akun (Registrasi)**: Pemilih/Voter **TIDAK PERLU MENDAFTAR AKUN ATAU LOGIN** untuk memberikan hak suaranya. Login/Registrasi hanya ditujukan bagi Admin/Penyelenggara untuk mengelola event di CMS Dashboard.\n" .
            "- **Cara Melakukan Voting**:\n" .
            "  1. Buka halaman utama atau halaman Event.\n" .
            "  2. Pilih event aktif yang ingin Anda ikuti.\n" .
            "  3. Klik tombol 'Pilih' pada kandidat pilihan Anda.\n" .
            "  4. Masukkan Nama atau Email Anda.\n" .
            "  5. Jika event tersebut berbayar, masukkan Jumlah Suara lalu lakukan pembayaran dengan memilih metode pembayaran yang tersedia.\n" .
            "  6. Jika event gratis, suara Anda akan langsung terkirim dan dihitung.\n" .
            "- **Fitur Utama**: Hasil perolehan suara real-time (Real-time Results), sistem voting gratis yang praktis, serta sistem voting berbayar dengan berbagai pilihan metode pembayaran.\n" .
            "- **Visi**: Menjadi pionir platform e-voting terpercaya skala nasional yang berintegritas tinggi, menjamin kerahasiaan suara pemilih, serta menghapus kecurangan secara sistematis.\n" .
            "- **Misi**:\n" .
            "  1. Mengembangkan platform E-Voters.id dengan antarmuka (UI/UX) yang ramah pengguna bagi berbagai kalangan usia.\n" .
            "  2. Menerapkan enkripsi data dan sistem keamanan ketat guna menjamin kerahasiaan penuh suara pemilih.\n" .
            "  3. Mendorong efisiensi logistik penyelenggaraan pemilu dengan meminimalisir penggunaan kertas suara fisik (paperless) secara ramah lingkungan.\n" .
            "- **Founder/Pendiri & Pemilik**: Aries Mulyono. Beliau merupakan pendiri PRO ATS Music Center, aktif sebagai aktivis marching band, konsultan musik, dan pegiat dunia musik tanah air. Beliau menginisiasi platform E-Voters.id agar pemilu di berbagai tingkat organisasi bisa terlaksana lebih modern, transparan, dan hemat biaya.\n" .
            "- **Hubungi Customer Service**: Jika pemilih/voter membutuhkan bantuan umum, mengalami kendala teknis/pembayaran, atau memiliki pertanyaan khusus yang butuh respon tim kami, arahkan mereka untuk menghubungi WhatsApp Customer Service dengan menyertakan tautan ini: https://wa.me/6281290174510 (JANGAN menuliskan nomor telepon manual, cukup sertakan tautan tersebut).";

        // Construct the messages payload
        $messages = [];
        $messages[] = ['role' => 'system', 'content' => $systemPrompt];

        // Format history
        foreach ($chatHistory as $chat) {
            if (isset($chat['role']) && isset($chat['content'])) {
                $messages[] = [
                    'role' => $chat['role'] === 'user' ? 'user' : 'assistant',
                    'content' => $chat['content']
                ];
            }
        }

        // Add current message
        $messages[] = ['role' => 'user', 'content' => $userMessage];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(30)->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => $model,
                'messages' => $messages,
                'temperature' => 0.3,
                'max_tokens' => 512,
            ]);

            if ($response->failed()) {
                Log::error('Groq API Error: ' . $response->body());
                return response()->json([
                    'status' => 'error',
                    'message' => 'Koneksi ke otak asisten Vera terputus. Silakan coba beberapa saat lagi.'
                ], 502);
            }

            $responseData = $response->json();
            $reply = $responseData['choices'][0]['message']['content'] ?? null;

            if (!$reply) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Vera tidak memberikan respon yang valid.'
                ], 502);
            }

            return response()->json([
                'status' => 'success',
                'reply' => $reply
            ]);

        } catch (\Exception $e) {
            Log::error('AiChatController Exception: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan sistem saat menghubungi asisten Vera.'
            ], 500);
        }
    }
}
